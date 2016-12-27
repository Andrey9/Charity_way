<div class="wrap_tell">
    <div class="bg">
        <div class="wrap_header">
            <div class="tell">
                <h3 class="caption_tell">@lang('front_labels.share')</h3>
                <div class="social_network">
                    <a  href="https://www.facebook.com/sharer.php?u={!! urlencode(url()->current()) !!}" class="contact" id="fb-share"
                        onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600'); return false;">
                        <div class="facebook"></div>
                        <div class="count_users">
                            <?php
                                $json = file_get_contents('http://graph.facebook.com/?id='.url()->current());
                                $result = json_decode($json);
                                echo isset($result->{'share'}->{'share_count'}) ? $result->{'share'}->{'share_count'} : 0;
                            ?>
                        </div>
                    </a>
                    <script type="text/javascript">
                        document.write(VK.Share.button({url: '{!! url()->current() !!}', title:'{!! $model->meta_title !!}' }, {type: 'custom',
                            text:   '<i class="contact" id="fb-share">'+
                            '<div class="vk"></div>'+
                                    '<div class="count_users">'
                                    +'<?php
                                    $val = intval(explode(',' , file_get_contents('https://vk.com/share.php?act=count&index=1&url='.url()->current()))[1]);
                                    $val = !$val || empty($val) ? 0 : $val;
                                    echo $val;
                                    ?>'
                                    +'</div></i>'
                        }));
                    </script>
                    <a class="contact"
                          href="https://twitter.com/share?url=http://fotobym.com.ua{{--{!! urlencode(url()->current()) !!}--}}&text={!! urlencode($model->meta_title) !!}"
                       onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=600'); return false;">
                        <div class="twiter"></div>
                        <div class="count_users"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
