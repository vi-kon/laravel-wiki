<?php

namespace ViKon\Wiki\Parser;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use ViKon\Parser\Lexer\Lexer;
use ViKon\Parser\Parser;
use ViKon\Parser\Renderer\Renderer;
use ViKon\Parser\Token;
use ViKon\ParserMarkdown\MarkdownRuleSet;
use ViKon\ParserMarkdown\Rule\Single\HeaderAtxRule;
use ViKon\ParserMarkdown\Rule\Single\HeaderSetextRule;
use ViKon\ParserMarkdown\Skin\BootstrapSkin;

/**
 * Class WikiParser
 *
 * @package ViKon\Wiki\Parser
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class WikiParser
{
    /** @type \Illuminate\Contracts\Container\Container */
    protected $container;

    /** @type \ViKon\Parser\Parser */
    protected $parser;

    /** @type \ViKon\Parser\Lexer\Lexer */
    protected $lexer;

    /** @type \ViKon\Parser\Renderer\Renderer */
    protected $renderer;

    /** @type array */
    protected $toc;

    /** @type \ViKon\Wiki\Parser\Metadata */
    protected $metadata;

    /**
     * WikiParser constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->parser   = new Parser();
        $this->lexer    = new Lexer();
        $this->renderer = new Renderer();

        $markdownSet = new MarkdownRuleSet();
        $markdownSet->init($this->parser, $this->lexer);

        $bootstrapSkin = new BootstrapSkin();
        $bootstrapSkin->init($this->parser, $this->renderer);

        $this->registerTocCollector();
    }

    /**
     * Parse text
     *
     * @param string      $content
     * @param string|null $title
     *
     * @return \ViKon\Wiki\Parser\Metadata
     */
    public function parse($content, $title = null)
    {
        // Reset all global property
        $this->toc = [];

        $this->metadata = (new Metadata())
            ->setTitle($title)
            // This call is need to be done first, because this fire events
            ->setContent($this->parser->render("\n" . str_replace("\r\n", "\n", $content) . "\n", 'bootstrap'))
            ->setToc($this->toc);

        return $this->metadata;
    }

    /**
     * Get last parsed content data
     *
     * @return \ViKon\Wiki\Parser\Metadata|null return NULL if no previous parse found
     */
    public function getLastParsed()
    {
        return $this->metadata;
    }

    /**
     * Register header collector for table of content
     */
    protected function registerTocCollector()
    {
        $dispatcher = $this->container->make(Dispatcher::class);

        $events = [
            'vikon.parser.token.render.' . HeaderSetextRule::NAME,
            'vikon.parser.token.render.' . HeaderAtxRule::NAME,
        ];

        $dispatcher->listen($events, function (Token $token) {
            $content = $token->get('content', '');
            $level   = $token->get('level');
            $temp    = &$this->toc;

            // Go down to given level
            for ($i = $level; $i > 1; $i--) {
                if (count($temp) === 0) {
                    $temp[] = [];
                } elseif (is_string(end($temp))) {
                    $last        = array_pop($temp);
                    $temp[$last] = [];
                }
                end($temp);
                $temp = &$temp[key($temp)];
            }
            $temp[] = $content;
        });
    }
}