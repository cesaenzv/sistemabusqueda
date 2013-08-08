(function($){

        $.fn.circleLoading = function(options){
                var circles = '<div class="loading"><div class="circle"></div><div class="circle1"></div></div>';
                var overlay ='<div class="overlay"></div>'
                var settings = $.extend({} , defaults, options);
                this.each(function(){
                        var $this = $(this);
                        $this.parent().css({'position':'relative'}).end().prepend(overlay);

                        if(settings.action === 'show'){
                                $this.prepend(circles);
                        }else if(settings.action === 'hide'){
                                $this.find('.loading').remove().end().parent().find('.overlay').remove();

                        }

                });

                $('.loading').addClass(settings.animation);
                return this;

        }

        var defaults = {
                animation: 'cocentric',
                color:'blue',
                action:'show'
        }


})(jQuery);