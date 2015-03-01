@extends('bootstrap::modal/modal')


@section('title')
    <i class="icon-io-history"></i>
    &nbsp;
    @lang('wiki::page/show.modal.history.title')
@overwrite


@section('body')
    <div class="row wiki-history">
        <div class="col-sm-4">
            <div class="list-group">
                @foreach($contents as $content)
                    <a href="#diff-{{$content['content']->id}}" class="list-group-item">
                        @if($content['diff']->getDeletedCount() > 0)
                            <span class="badge alert-danger">- {{$content['diff']->getDeletedCount()}}</span>
                        @endif
                        @if($content['diff']->getInsertedCount() > 0)
                            <span class="badge alert-success">+ {{$content['diff']->getInsertedCount()}}</span>
                        @endif
                        <time datetime="{{$content['content']->created_at->toATOMString()}}"></time>
                        <br/>
                        {{$content['content']->created_at}}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-sm-8">
            @foreach($contents as $content)
                <div id="diff-{{$content['content']->id}}" class="wiki-history-diff">
                    @foreach($content['diff']->getGroups() as $i => $group)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @lang('wiki::page/show.modal.history.lines', ['hunk' => $i + 1, 'lines' => ($group->getFirstPosition() + 1) . ' - ' . ($group->getLastPosition() + 1)])
                            </div>
                            <table class="table table-condensed">
                                @foreach($group->getEntries() as $entry)
                                    <tr class="@if($entry instanceof \ViKon\Diff\Entry\InsertedEntry)success @elseif($entry instanceof \ViKon\Diff\Entry\DeletedEntry)danger @endif">

                                        @if($entry instanceof \ViKon\Diff\Entry\InsertedEntry)
                                            <td class="line text-muted">-</td>
                                        @else
                                            <td class="line text-muted">{{$entry->getOldPosition() + 1}}</td>
                                        @endif

                                        @if($entry instanceof \ViKon\Diff\Entry\DeletedEntry)
                                            <td class="line text-muted">-</td>
                                        @else
                                            <td class="line text-muted">{{$entry->getNewPosition() + 1}}</td>
                                        @endif

                                        <td>{{$entry}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@overwrite


@section('append')
    <script type="text/javascript">
        (function($){
            var modal = $('#modal');
            modal.find('time').timeago();

            modal.find('.list-group-item').eq(0).addClass('active');
            modal.find('.wiki-history-diff').eq(0).addClass('active');
            modal.find('.list-group-item').on('click', function(e) {
                e.preventDefault();
                e.returnValue = false;
                modal.find('.list-group-item').removeClass('active');
                modal.find('.wiki-history-diff').removeClass('active');

                $(this).addClass('active');
                modal.find($(this).attr('href')).addClass('active');
            })
        }(jQuery));
    </script>
@append