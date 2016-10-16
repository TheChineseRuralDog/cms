/**
 * Created by chenfh on 2016/9/11.
 */
/// <reference path="jquery-3.0.0.min.js">
var App=function(){
    var ajax={};
    var inits={
        fade:{
          exec:function(bannermain,o){
              //图片简单切换调用语句 imgtransition({speed: 3000, animate: 1000});
              $.fn.imgtransition = function(o){
                  var defaults = {
                      speed : 5000,
                      animate : 1000
                  };
                  o = $.extend(defaults, o);

                  return this.each(function(){
                      var arr_e = $("li", this);
                      arr_e.css({position: "absolute"});
                      arr_e.parent().css({margin: "0", padding: "0", "list-style": "none", overflow: "hidden"});

                      function shownext(){
                          var active = arr_e.filter(".active").length ? arr_e.filter(".active") : arr_e.first();
                          var next =  active.next().length ? active.next() : arr_e.first();
                          active.css({"z-index": 9});
                          next.css({opacity: 0.0, "z-index": 10}).addClass('active').animate({opacity: 1.0}, o.animate, function(){
                              active.removeClass('active').css({"z-index": 8});
                          });
                      }

                      arr_e.first().css({"z-index": 9});
                      setInterval(function(){
                          shownext();
                      },o.speed);

                  });
              };

              $(bannermain).imgtransition(o);

          }
        },
        nav_w:{
            exec:function(){
                var _speed = 0; // in ms
                var _hold = $('.menu ul.nav');
                var _t = null;
                if(_hold.length){
                    var _list = _hold.children();
                    _list.each(function(){
                        var _el = $(this);
                        var _box = _el.children('div.nav-w');
                        var _sub = _box.children();
                        _box.show().width(_sub.outerWidth()).hide();
                        _el.mouseenter(function(){
                            var _this = this;
                            _t = setTimeout(function(){
                                $(_this).css('zIndex', 10);
                                _el.addClass('hover');
                                if(_box.is(':hidden')){
                                    _box.show();
                                    _sub.css('marginTop', -_sub.outerHeight());
                                }
                                _sub.stop().animate({marginTop: 0}, _speed);
                            },300)
                        }).mouseleave(function(){
                            if(_t) clearTimeout(_t);
                            var _this = $(this);
                            $(this).css('zIndex', 5);
                            if(_sub.length){
                                _sub.stop().animate({marginTop: -_sub.outerHeight()}, _speed, function(){
                                    _box.hide();
                                    _el.removeClass('hover');
                                    _this.css('zIndex', 1);
                                });
                            }else{
                                _el.removeClass('hover');
                            }
                        });
                    });
                }
            }
        },
        exec:function(){
            //    var reset=function(){
            //        $(".banner_main>ul>li").last().after($(".banner_main>ul>li").first());
            //        $(".banner_main>ul").css({"marginLeft":0});
            //    }
            var reset1=function(){
                $(".small_banner>ul>li").last().after($(".small_banner>ul>li").first());
                $(".small_banner>ul").css({"marginLeft":0});
            }
            //var scroll=function(){
            //    $(".banner_main>ul").animate({"marginLeft":"-1920px"
            //    },2000,function(){
            //        reset();
            //    });
            //}
            //window.setTimeout(function(){
            //    scroll();
            //    window.setInterval(function(){
            //        scroll();
            //    },4000);
            //},2000)
            ////点击事件
            $(".btn1").bind("click",function(){
                $(".small_banner>ul>li").first().before($(".small_banner>ul>li").last());
                $(".small_banner>ul").css({"marginLeft":"-380px"});
                $(".small_banner>ul").animate({"marginLeft":"0px"
                },1000,function(){
                });
            });
            $(".btn2").bind("click",function(){
                $(".small_banner>ul").animate({"marginLeft":"-380px"
                },1000,function(){
                    reset1();
                });
            });
            var o = {
                speed : 3000,
                animate : 1000
            };
            var bannermain=$('.banner_main');
            this.fade.exec(bannermain,o);
            this.nav_w.exec();
        }
    };
    this.init=function(){
        window.setTimeout(function(){
            inits.exec();
        },50)
    }
}