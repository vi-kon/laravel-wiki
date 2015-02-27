<?php


namespace ViKon\Wiki;

use ViKon\Parser\lexer\Lexer;
use ViKon\Parser\Parser;
use ViKon\Parser\renderer\Renderer;
use ViKon\Parser\Token;
use ViKon\Parser\TokenList;
use ViKon\ParserMarkdown\MarkdownSet;
use ViKon\ParserMarkdown\rule\single\HeaderAtx;
use ViKon\ParserMarkdown\rule\single\HeaderSetext;
use ViKon\ParserMarkdown\rule\single\LinkInline;
use ViKon\ParserMarkdown\rule\single\Reference;

/**
 * Class WikiParser
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki
 */
class WikiParser {
    protected $urls = [];
    protected $toc = [];

    /**
     * @param string $title
     * @param string $content
     *
     * @return array
     */
    public static function parsePage($title, $content) {
        $self = new self();

        return $self->parse($title, $content);
    }

    /**
     * @param string $txt
     *
     * @return string
     */
    public static function generateId($txt) {
        return strtolower(preg_replace(['/[^\dA-Za-z ]/', '/ /'], ['', '-'], $txt));
    }

    /**
     * @param string $content
     *
     * @return string
     * @throws \ViKon\Parser\ParserException
     */
    public static function parseContent($content) {
        $parser = new Parser();
        $lexer = new Lexer();
        $renderer = new Renderer();

        $markdownSet = new MarkdownSet();
        $markdownSet->init($parser, $lexer, $renderer);

        return $parser->render("\n" . $content . "\n", 'bootstrap');
    }

    /**
     * Public instance not allowed
     */
    protected function __construct() {
    }

    /**
     * @param string $title
     * @param string $content
     *
     * @return array
     * @throws \ViKon\Parser\ParserException
     */
    public function parse($title, $content) {
        $parser = new Parser();
        $lexer = new Lexer();
        $renderer = new Renderer();

        $markdownSet = new MarkdownSet();
        $markdownSet->init($parser, $lexer, $renderer);

        $events = [
            'vikon.parser.token.render.' . HeaderSetext::NAME,
            'vikon.parser.token.render.' . HeaderAtx::NAME
        ];
        \Event::listen($events, [$this, 'registerTOC']);

        \Event::listen('vikon.parser.token.render.' . LinkInline::NAME, [$this, 'registerLinkInline']);
//        \Event::listen('vikon.parser.token.render.' . LinkReference::NAME, [$this, 'registerLinkReference']);

        $this->toc = [app('html')->link('#' . self::generateId($title), $title)];

        return [
            $parser->render("\n" . $content . "\n", 'bootstrap'),
            $this->toc,
            $this->urls,
        ];
    }

    /**
     * @param \ViKon\Parser\Token $token
     */
    public function registerTOC(Token $token) {
        $content = $token->get('content', '');
        $level = $token->get('level');
        $link = app('html')->link('#' . $this->generateId($content), $content);
        $temp =& $this->toc;
        for ($i = $level; $i > 1; $i--) {
            if (empty($temp)) {
                $temp[] = [];
            } elseif (is_string(end($temp))) {
                $last = array_pop($temp);
                $temp[$last] = [];
            }
            end($temp);
            $temp =& $temp[key($temp)];
        }
        $temp[] = $link;
    }

    /**
     * @param \ViKon\Parser\Token $token
     */
    public function registerLinkInline(Token $token) {
        $this->registerLink($token->get('url'));
    }

    /**
     * @param string $url
     */
    public function registerLink($url) {
        if (preg_match('/(?:\/[]\d!"#$%&\'()*+,.:;<=>?@[\\\\_`a-z{|}~^-]+){0,9}\/?/', $url)) {
            $this->urls[] = $url;
        }
    }

    /**
     * @param \ViKon\Parser\Token     $token
     * @param \ViKon\Parser\TokenList $tokenList
     *
     * @throws \ViKon\Parser\LexerException
     */
    public function registerLinkReference(Token $token, TokenList $tokenList) {
        $reference = $token->get('reference');
        if ($reference instanceof Token) {
            $referenceToken = $reference;
        } else {
            if (trim($reference) === '') {
                $reference = strtolower(trim($token->get('label')));
            }

            $tokens = $tokenList->getTokensByCallback(function (Token $token) use ($reference) {
                return $token->getName() === Reference::NAME && $token->get('reference', null) === $reference;
            });

            if (($referenceToken = reset($tokens)) === false) {
                return;
            }
        }

        $this->registerLink($referenceToken->get('url'));
    }
}