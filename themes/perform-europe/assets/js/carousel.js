jQuery(document).ready(function ($) {
    var mySwiper = new Swiper(".swiper", {
        modules: [
            function ({ swiper: e, on: r }) {
                r("beforeInit", function () {
                    if ("coverflow" !== e.params.effect) return;
                    // Use jQuery to add a class to the Swiper container
                    $(e.$el).addClass(`${e.params.containerModifierClass}coverflow`);
                    var r = { watchSlidesProgress: true, centeredSlides: true };
                    // Use jQuery to update Swiper parameters
                    $.extend(e.params, r);
                    $.extend(e.originalParams, r);
                });

                r("progress", function () {
                    if ("coverflow" !== e.params.effect) return;
                    var r = e.slides.length;
                    e.slides.each(function (s) {
                        var t = $(s); // Use jQuery to select the slide
                        var o = s.progress;
                        var i = Math.abs(o);
                        var a = 1;
                        if (i > 1) {
                            a = 0.3 * (i - 1) + 1;
                        }
                        var n = t.find(".swiper-carousel-animate-opacity"); // Use jQuery to find elements within the slide
                        var l = o * a * 50 * (e.rtlTranslate ? -1 : 1) + "%";
                        var c = 1 - 0.2 * i;
                        var u = r - Math.abs(Math.round(o));
                        // Use jQuery to set CSS properties
                        t.css({
                            transform: `translateX(${l}) scale(${c})`,
                            zIndex: u,
                            opacity: i > 3 ? 0 : 1
                        });
                        n.each(function () {
                            // Use jQuery to manipulate each found element
                            $(this).css('opacity', 1 - i / 3);
                        });
                    });
                });

                r("setTransition", function (s) {
                    if ("coverflow" === e.params.effect) {
                        e.slides.each(function (t) {
                            var r = $(t); // Use jQuery to select the slide
                            var o = r.find(".swiper-carousel-animate-opacity"); // Use jQuery to find elements within the slide
                            // Use jQuery to set transition duration
                            r.css('transition-duration', `${s}ms`);
                            o.each(function () {
                                // Use jQuery to set transition duration for found elements
                                $(this).css('transition-duration', `${s}ms`);
                            });
                        });
                    }
                });
            }
        ],
        effect: "coverflow",
        loop: true,
          // mousewheel: {
          //   thresholdDelta: 70
          // },
        centeredSlides: true,
        slidesPerView: "2",
            coverflowEffect: {
            rotate: 0,
            stretch: 20,
            depth: 100,
            modifier: 2,
            slideShadows: false
        },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        pagination: { el: ".swiper-pagination" }
    });
});

// var swiper = new Swiper(".swiper", {
//     effect: "coverflow",
//     centeredSlides: true,
//     autoplay: {
//         delay: 3000,
//         disableOnInteraction: false
//     },
//     loop: true,
//     slidesPerView: "2",
//     coverflowEffect: {
//         rotate: 0,
//         stretch: 30,
//         depth: 100,
//         modifier: 5,
//         slideShadows: false
//     },
//     navigation: {
//         prevEl: ".swiper-button-prev",
//         nextEl: ".swiper-button-next"
//     },
//     pagination: {
//         el: ".swiper-pagination",
//         clickable: false
//     }
// });


