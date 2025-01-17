    // Landing Text Animation -->
		$(".landing-img-wrp").each(function (index) {
			let tlMT = gsap.timeline({ repeat: -1, defaults: { ease: "expo.inOut", duration: 1, delay: 0.5 } });
			tlMT.to(".l__title-wrp", { yPercent: -100 });
			tlMT.to(".l__title-wrp", { yPercent: -200 });
			tlMT.to(".l__title-wrp", { yPercent: -300 });
			tlMT.to(".l__title-wrp", { yPercent: -400 });
			tlMT.to(".l__title-wrp", { yPercent: -500 });
			tlMT.to(".l__title-wrp", { yPercent: -600 });
		});

 // Intro Animation -->
    $(".loading-wrp").each(function (index) { 
    
        if ($(window).width() > 768) {
            window.onload = function () {
                // Check if the animation has been played before
                if (sessionStorage.getItem("animationPlayed") !== 'true') {
                    // Define your animation code here
                    $('.loading-wrp').css('display', 'flex');  
                    let tlIntroAll = gsap.timeline({ paused: true });
                    tlIntroAll.to('.loading__cont-wrp', { width: "27rem", duration: .8, ease: "power2.inOut"}, 0);
                    tlIntroAll.to('.loading__cont-wrp', { width: "36rem", duration: .8, ease: "power2.inOut"}, .8);
                    tlIntroAll.to('.loading__cont-wrp', { width: "41rem", duration: .8, ease: "power2.inOut"}, 1.6);
            
                    tlIntroAll.to('.l__txt--s', { opacity: 1, duration: .6, ease: "power2.inOut", stagger: { amount: 1.5,} }, 0.1);
            
                    tlIntroAll.to('.l__txt--xl', { yPercent: 200, opacity: 0.5, duration: 0.6, ease: "power2.in"}, 2.6);
                    tlIntroAll.to('.l__txt--s', { yPercent: 200, opacity: 0.5, duration: 0.6, ease: "power2.in", stagger: { amount: 0.1,} }, 2.7);
                    tlIntroAll.to('.loading-wrp', { opacity: 0, duration: .8, ease: "power2.inOut"}, 3.2);
            
                  $(document).ready(function () {
                   setTimeout(function (){
                    tlIntroAll.restart();      
                    }, 500);
                    setTimeout(function (){
                        $('.loading__cont-wrp').css('overflow', 'hidden');      
                        }, 2800);
                    setTimeout(function (){
                        $('.loading-wrp').css('display', 'none');      
                        }, 4500);
                 });
            
                    // Set the flag in sessionStorage to indicate the animation has been played
                    sessionStorage.setItem("animationPlayed", 'true');
                    sessionStorage.clear();
                }
            }
            
            $('.loading-wrp').css('display', 'none');  
    
           
        }
    });             
            

$(document).ready(function() {
	$('#open-video').on('click', function () {
        $('.video__embed-wrp').addClass('open');
        $('.video__embed-wrp').show();
    });
    $('.video-close__link').on('click', function () {
        $('.video__embed-wrp').removeClass('open');
        $('.video__embed-wrp').hide();
    });
	
    if ($(window).width() > 768) {
    // Function to add class when scrolled down 50vh
    function addClassOnScroll() {           
        var scrollPosition = $(window).scrollTop();
        var windowHeight = $(window).height();

        // Check if the element does not have the class "open"
        if (!$('.fixed__filter-menu').hasClass('open')) {
            if (scrollPosition >= (0.9 * windowHeight)) {
                $('.site-menu').addClass('shrinked');
                $('.menu__small-img').addClass('active');
            } else {
                $('.site-menu').removeClass('shrinked');
                $('.menu__small-img').removeClass('active');
            }
        }
    }

    // Attach the scroll event listener
    $(window).on('scroll', addClassOnScroll);

    }

    $('.menu__small-img').on('click', function() {        
        $('.site-menu').removeClass('shrinked');
        $('.menu__small-img').removeClass('active');
      });

});

$(document).ready(function () {
    $(".w-webflow-badge").removeClass("w-webflow-badge").empty();
});
$('#menu-open').on('click', function () {
    $('.menu--dark').addClass('open');
    $('.menu').addClass('open');
});
$('#menu-close').on('click', function () {
    $('.menu--dark').removeClass('open');
    $('.menu').removeClass('open');
});
$('.menu-close').on('click', function () {
    $('.menu--dark').removeClass('open');
    $('.menu').removeClass('open');
});
$('.dropdown-itm').on('click', function () {
   
    $(this).toggleClass('dd-open');
    $(this).find('.dd__txt').toggleClass('visible');
});

const cursors = document.querySelectorAll(".custom-cursor");

cursors.forEach((div, index) => {
    window.addEventListener("mousemove", function (dets) {
        div.style.left = `${dets.clientX}px`;
        div.style.top = `${dets.clientY}px`;
    });
});

$('.list__itm-wrp').on('mouseenter mouseleave', function () {
    $(".cursor-wrp").toggleClass('hide');
});
$('.pro__slid__itm__cont').on('mouseenter mouseleave', function () {
    $(".cursor-wrp").toggleClass('hide');
});

$('.cursor-show').on('mouseenter mouseleave', function () {
    $(".cursor-wrp").toggleClass('hide');
});

$('#cookie-accept').on('click', function () {
    $('.cookie-banner').css('display', 'none');
});
$('#cookie-decline').on('click', function () {
    $('.cookie-banner').css('display', 'none');
});

$(".filter-menu__open").on('click', function (e) {
    e.preventDefault();
    if ($(window).width() > 768) {
        $(".fixed__filter-menu").addClass('open');
        $(".fixed__filter-menu").removeClass('shrinked');
        $('.filter-menu--extra__txt').css('display', 'inline');
$(this).css('display', 'none');
$('.filter-itm__order').css('opacity', '1');
$('.fixed__cta__txt__close').css('display', 'block');
$('.filter-menu__arrow').css('transform', 'rotate(30deg)');
$('.btn-reset').css('opacity', '1');
    } else {
        $(".fixed__filter-menu").addClass('open');
$(this).css('display', 'none');
$('.filter-itm__order').css('opacity', '1');
$('.fixed__cta__txt__close').css('display', 'block');
$('.navbar-wrp--difference').css('display', 'none');
$('.filter-menu__arrow').css('transform', 'rotate(30deg)');
$('.btn-reset').css('opacity', '1');
$('.filter-menu--extra__txt').css('display', 'inline');
    }
});

$('.filter-menu__arrow').on('click', function () {
    $(".fixed__filter-menu").removeClass('open');
$('.filter-itm__order').css('opacity', '0');
$('.filter-menu__open').css('display', 'block');
$(this).css('transform', 'rotate(-30deg)');
$('.navbar-wrp--difference').css('display', 'flex');
$('.fixed__cta__txt__close').css('display', 'none');
$('.btn-reset').css('opacity', '0');
$('.filter-menu--extra__txt').css('display', 'inline');
});


$('.fixed__cta__txt__close').on('click', function () {
$(".fixed__filter-menu").removeClass('open');
$('.filter-itm__order').css('opacity', '0');
$('.filter-menu__open').css('display', 'block');
$(this).css('display', 'none');
$('.navbar-wrp--difference').css('display', 'flex');
$('.filter-menu__arrow').css('transform', 'rotate(-30deg)');
$('.btn-reset').css('opacity', '0');
$('.filter-menu--extra__txt').css('display', 'inline');
});

$('.reset-filter').on('click', function () {
    location.reload();
});

$('#btn-w-open').on('click', function () {
	if($(".check-box").hasClass('is--checked'))
		{
		    $('.action-warning').addClass('open');	
		}
	else{
		alert("To proceed, kindly tick the checkbox. Thanks!");
	}
});
$('#btn-w-close').on('click', function () {
    $('.action-warning').removeClass('open');
});
$('.check-box').on('click', function () {
    $(this).toggleClass('is--checked');
});

$('.form-filter-itm__head').on('click', function () {
    $(this).siblings(".form-filter-wrp").toggleClass('hide');
    $(this).find(".txt__arrow").toggleClass('up');
});



$('.form__itm-i').on('click', function () {
    $(this).addClass('f-interactive');
    $(this).find('.form__txt-i').addClass('f-interactive');
});


$('.navbar-wrp').css('background-image', 'none');





/**
 * SplitType
 * https://github.com/lukePeavey/SplitType
 * @version 0.3.3
 * @author Luke Peavey <lwpeavey@gmail.com>
 */

!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):(t="undefined"!=typeof globalThis?globalThis:t||self).SplitType=e()}(this,(function(){"use strict";function t(t,e){return Object.getOwnPropertyNames(Object(t)).reduce(((n,s)=>{const i=Object.getOwnPropertyDescriptor(Object(t),s),o=Object.getOwnPropertyDescriptor(Object(e),s);return Object.defineProperty(n,s,o||i)}),{})}function e(t){return"string"==typeof t}function n(t){return Array.isArray(t)}function s(s={}){const i=t(s);let o;return void 0!==i.types?o=i.types:void 0!==i.split&&(o=i.split),void 0!==o&&(i.types=(e(o)||n(o)?String(o):"").split(",").map((t=>String(t).trim())).filter((t=>/((line)|(word)|(char))/i.test(t)))),(i.absolute||i.position)&&(i.absolute=i.absolute||/absolute/.test(s.position)),i}function i(t){const s=e(t)||n(t)?String(t):"";return{none:!s,lines:/line/i.test(s),words:/word/i.test(s),chars:/char/i.test(s)}}function o(t){return null!==t&&"object"==typeof t}function r(t){return o(t)&&/^(1|3|11)$/.test(t.nodeType)}function l(t){return n(t)?t:null==t?[]:function(t){return o(t)&&function(t){return"number"==typeof t&&t>-1&&t%1==0}(t.length)}(t)?Array.prototype.slice.call(t):[t]}function c(t){let n=t;return e(t)&&(n=/^(#[a-z]\w+)$/.test(t.trim())?document.getElementById(t.trim().slice(1)):document.querySelectorAll(t)),l(n).reduce(((t,e)=>[...t,...l(e).filter(r)]),[])}(()=>{function t(...t){const e=t.length;for(let n=0;n<e;n++){const e=t[n];1===e.nodeType||11===e.nodeType?this.appendChild(e):this.appendChild(document.createTextNode(String(e)))}}function e(...t){for(;this.lastChild;)this.removeChild(this.lastChild);t.length&&this.append(...t)}function n(...t){const e=this.parentNode;let n=t.length;if(e)for(n||e.removeChild(this);n--;){let s=t[n];"object"!=typeof s?s=this.ownerDocument.createTextNode(s):s.parentNode&&s.parentNode.removeChild(s),n?e.insertBefore(this.previousSibling,s):e.replaceChild(s,this)}}"undefined"!=typeof Element&&(Element.prototype.append||(Element.prototype.append=t,DocumentFragment.prototype.append=t),Element.prototype.replaceChildren||(Element.prototype.replaceChildren=e,DocumentFragment.prototype.replaceChildren=e),Element.prototype.replaceWith||(Element.prototype.replaceWith=n,DocumentFragment.prototype.replaceWith=n))})();const{entries:d,keys:p,values:h}=Object,u="_splittype",a={};let f=0;function g(t,e,n){if(!o(t))return console.warn("[data.set] owner is not an object"),null;const s=t[u]||(t[u]=++f),i=a[s]||(a[s]={});return void 0===n?e&&Object.getPrototypeOf(e)===Object.prototype&&(a[s]={...i,...e}):void 0!==e&&(i[e]=n),n}function y(t,e){const n=o(t)?t[u]:null,s=n&&a[n]||{};return void 0===e?s:s[e]}function m(t){const e=t&&t[u];e&&(delete t[e],delete a[e])}const w="\\ud800-\\udfff",b="\\u0300-\\u036f\\ufe20-\\ufe23",C="\\u20d0-\\u20f0",E="\\ufe0e\\ufe0f",S="[\\ud800-\\udfff]",x=`[${b}\\u20d0-\\u20f0]`,$="\\ud83c[\\udffb-\\udfff]",v="[^\\ud800-\\udfff]",j="(?:\\ud83c[\\udde6-\\uddff]){2}",O="[\\ud800-\\udbff][\\udc00-\\udfff]",W="\\u200d",T=`(?:${x}|${$})`+"?",N="[\\ufe0e\\ufe0f]?",D=N+T+("(?:\\u200d(?:"+[v,j,O].join("|")+")"+N+T+")*"),R=`(?:${[`${v}${x}?`,x,j,O,S].join("|")}\n)`,k=RegExp(`${$}(?=${$})|${R}${D}`,"g"),A=RegExp(`[${[W,w,b,C,E].join("")}]`);function B(t){return A.test(t)}function F(t){return B(t)?function(t){return t.match(k)||[]}(t):function(t){return t.split("")}(t)}function L(t,n=""){var s;return(t=null==(s=t)?"":String(s))&&e(t)&&!n&&B(t)?F(t):t.split(n)}function P(t,n){const s=document.createElement(t);return n?(Object.keys(n).forEach((t=>{const i=n[t],o=e(i)?i.trim():i;null!==o&&""!==o&&("children"===t?s.append(...l(o)):s.setAttribute(t,o))})),s):s}var H={splitClass:"",lineClass:"line",wordClass:"word",charClass:"char",types:["lines","words","chars"],absolute:!1,tagName:"div"};function M(e,n){const s=i((n=t(H,n)).types),o=n.tagName,r=e.nodeValue,l=document.createDocumentFragment();let c=[],d=[];return/^\s/.test(r)&&l.append(" "),c=function(t,e=" "){return(t?String(t):"").trim().replace(/\s+/g," ").split(e)}(r).reduce(((t,e,i,r)=>{let c,p;return s.chars&&(p=L(e).map((t=>{const e=P(o,{class:`${n.splitClass} ${n.charClass}`,style:"display: inline-block;",children:t});return g(e,"isChar",!0),d=[...d,e],e}))),s.words||s.lines?(c=P(o,{class:`${n.wordClass} ${n.splitClass}`,style:"display: inline-block; "+(s.words&&n.absolute?"position: relative;":""),children:s.chars?p:e}),g(c,{isWord:!0,isWordStart:!0,isWordEnd:!0}),l.appendChild(c)):p.forEach((t=>{l.appendChild(t)})),i<r.length-1&&l.append(" "),s.words?t.concat(c):t}),[]),/\s$/.test(r)&&l.append(" "),e.replaceWith(l),{words:c,chars:d}}function z(t,e){const n=t.nodeType,s={words:[],chars:[]};if(!/(1|3|11)/.test(n))return s;if(3===n&&/\S/.test(t.nodeValue))return M(t,e);const i=l(t.childNodes);if(i.length&&(g(t,"isSplit",!0),!y(t).isRoot)){t.style.display="inline-block",t.style.position="relative";const e=t.nextSibling,n=t.previousSibling,s=t.textContent||"",i=e?e.textContent:" ",o=n?n.textContent:" ";g(t,{isWordEnd:/\s$/.test(s)||/^\s/.test(i),isWordStart:/^\s/.test(s)||/\s$/.test(o)})}return i.reduce(((t,n)=>{const{words:s,chars:i}=z(n,e);return{words:[...t.words,...s],chars:[...t.chars,...i]}}),s)}function V(t){y(t).isWord?(m(t),t.replaceWith(...t.childNodes)):l(t.children).forEach((t=>V(t)))}function q(t,e,n){const s=i(e.types),o=e.tagName,r=t.getElementsByTagName("*"),c=[];let d,p,h,u=[],a=null,f=[];const m=t.parentElement,w=t.nextElementSibling,b=document.createDocumentFragment(),C=window.getComputedStyle(t),E=C.textAlign,S=.2*parseFloat(C.fontSize);return e.absolute&&(h={left:t.offsetLeft,top:t.offsetTop,width:t.offsetWidth},p=t.offsetWidth,d=t.offsetHeight,g(t,{cssWidth:t.style.width,cssHeight:t.style.height})),l(r).forEach((i=>{const o=i.parentElement===t,{width:r,height:l,top:d,left:p}=function(t,e,n,s){if(!n.absolute)return{top:e?t.offsetTop:null};const i=t.offsetParent,[o,r]=s;let l=0,c=0;if(i&&i!==document.body){const t=i.getBoundingClientRect();l=t.x+o,c=t.y+r}const{width:d,height:p,x:h,y:u}=t.getBoundingClientRect();return{width:d,height:p,top:u+r-c,left:h+o-l}}(i,o,e,n);/^br$/i.test(i.nodeName)||(s.lines&&o&&((null===a||d-a>=S)&&(a=d,c.push(u=[])),u.push(i)),e.absolute&&g(i,{top:d,left:p,width:r,height:l}))})),m&&m.removeChild(t),s.lines&&(f=c.map((t=>{const n=P(o,{class:`${e.splitClass} ${e.lineClass}`,style:`display: block; text-align: ${E}; width: 100%;`});g(n,"isLine",!0);const s={height:0,top:1e4};return b.appendChild(n),t.forEach(((t,e,i)=>{const{isWordEnd:o,top:r,height:l}=y(t),c=i[e+1];s.height=Math.max(s.height,l),s.top=Math.min(s.top,r),n.appendChild(t),o&&y(c).isWordStart&&n.append(" ")})),e.absolute&&g(n,{height:s.height,top:s.top}),n})),s.words||V(b),t.replaceChildren(b)),e.absolute&&(t.style.width=(t.style.width||p)+"px",t.style.height=d+"px",l(r).forEach((t=>{const{isLine:e,top:n,left:s,width:i,height:o}=y(t),r=y(t.parentElement),l=!e&&r.isLine;t.style.top=(l?n-r.top:n)+"px",t.style.left=e?h.left+"px":s-(l?h.left:0)+"px",t.style.height=o+"px",t.style.width=e?h.width+"px":i+"px",t.style.position="absolute"}))),m&&(w?m.insertBefore(t,w):m.appendChild(t)),f}let I=t(H,{});class X{static get data(){return a}static get defaults(){return I}static set defaults(e){I=t(I,s(e))}static setDefaults(e){return I=t(I,s(e)),H}static revert(t){c(t).forEach((t=>{const{isSplit:e,html:n,cssWidth:s,cssHeight:i}=y(t);e&&(t.innerHTML=n,t.style.width=s||"",t.style.height=i||"",m(t))}))}static create(t,e){return new X(t,e)}constructor(e,n){this.isSplit=!1,this.settings=t(I,s(n)),this.elements=c(e),this.split()}split(e){this.revert(),this.elements.forEach((t=>{g(t,"html",t.innerHTML)})),this.lines=[],this.words=[],this.chars=[];const n=[window.pageXOffset,window.pageYOffset];void 0!==e&&(this.settings=t(this.settings,s(e)));const o=i(this.settings.types);o.none||(this.elements.forEach((t=>{g(t,"isRoot",!0);const{words:e,chars:n}=z(t,this.settings);this.words=[...this.words,...e],this.chars=[...this.chars,...n]})),this.elements.forEach((t=>{if(o.lines||this.settings.absolute){const e=q(t,this.settings,n);this.lines=[...this.lines,...e]}})),this.isSplit=!0,window.scrollTo(n[0],n[1]),d(a).forEach((([t,{isRoot:e,isSplit:n}])=>{e&&n||(a[t]=null,delete a[t])})))}revert(){this.isSplit&&(this.lines=null,this.words=null,this.chars=null,this.isSplit=!1),X.revert(this.elements)}}return X}));


  let splitType = new SplitType("[hoverstagger='text']", {
    types: "words,chars",
    tagName: "span"
  });
  
  $("[hoverstagger='link']").each(function (index) {
    let text1 = $(this).find("[hoverstagger='text']").eq(0);
    let text2 = $(this).find("[hoverstagger='text']").eq(1);
  
    let tl = gsap.timeline({ paused: true });
    tl.to(text1.find(".char"), { yPercent: -100, duration: 0.3, ease: "power2.inOut", stagger: { amount: 0.1 } });
    tl.from(text2.find(".char"), { yPercent: 100, duration: 0.3, ease: "power2.inOut", stagger: { amount: 0.1 } }, 0);
  
    $(this).on("mouseenter", function () {
      tl.restart();
    });
     $(this).on("mouseleave", function () {
       tl.reverse();
     });
  });





  $(".fixed__filter-menu").each(function (index) { 
    $(document).ready(function() {
    if ($(window).width() > 768) {
    // Function to add class when scrolled down 50vh
    function addClassOnScroll() {
        var scrollPosition = $(window).scrollTop();
        var windowHeight = $(window).height();

        // Check if the element does not have the class "open"
        if (!$('.fixed__filter-menu').hasClass('open')) {
            if (scrollPosition >= (0.5 * windowHeight)) {
                $('.fixed__filter-menu').addClass('shrinked');
                $('.filter-menu--extra__txt').css('display', 'none');
            } else {
                $('.fixed__filter-menu').removeClass('shrinked');
                $('.filter-menu--extra__txt').css('display', 'inline');
            }
        }
    }

    // Attach the scroll event listener
    $(window).on('scroll', addClassOnScroll);
}});
  });


  
  // Menu Animation -->
  let typeSplit = new SplitType('.txt--4rem', {
    types: 'lines',
    tagName: 'span'
})
const text = new SplitType('.menu__link', {
    types: 'lines',
    tagName: 'span'
})


let tlMenu = gsap.timeline({ paused: true });
tlMenu.from('.line', { yPercent: 120, duration: 0.6, ease: "power2.out", stagger: { amount: 0.6, } });
tlMenu.from('.menu__link__line', { width: 0, duration: 0.4, ease: "power2.out", stagger: { amount: 0.8, } }, 0);
tlMenu.fromTo('.menu__sub-img', { opacity: 0, height: "0rem"}, { opacity: 1, height: "10rem", duration: 0.3}, 0.6);
tlMenu.fromTo('.menu', { opacity: 0,}, { opacity: 1, duration: 0.3}, 0);


$("#menu-open").on("click", function () {
    tlMenu.restart();
});


    // slider-bar Animation -->
    $(".partners__slider").each(function (index) { 
    
        $('.partners__slider').on('mouseenter', function() {
            $(this).css('.partners__slider::-webkit-scrollbar', '10px');
          });

          $('.partners__slider').hover(
            function () {
              $(this).css('width', '400px'); // Change the width on hover
            },
            function () {
              $(this).css('width', '300px'); // Restore the original width on mouse leave
            }
          );

    });    


$(".site-menu").each(function (index) {
    $('#ms-who').on('click', function () {
        $('.menu--dark').removeClass('open');
        $('.menu').removeClass('open');
        smoother.scrollTo("#who-we-are", true);
    });
    $('#ms-time').on('click', function () {
        $('.menu--dark').removeClass('open');
        $('.menu').removeClass('open');
        smoother.scrollTo("#timeline", true);
    });
    $('#ms-teams').on('click', function () {
        $('.menu--dark').removeClass('open');
        $('.menu').removeClass('open');
        smoother.scrollTo("#teams", true);
    });
    $('#ms-partners').on('click', function () {
        $('.menu--dark').removeClass('open');
        $('.menu').removeClass('open');
        smoother.scrollTo("#consortium-partners", true);
    });
});

