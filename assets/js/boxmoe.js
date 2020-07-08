!function($) {
    "use strict";
    $(document).pjax('a[target!=_blank]', '#global', '#longining', '#longinreg', {
        fragment: '#global,#longining,#longinreg',
        timeout: 6000
    });
    $(document).on('pjax:timeout',
    function() {
        $('#begin').fadeOut();
        $('#loading').delay(100).fadeOut('slow');
    });
    $(document).on('pjax:click',
    function() {
        $('#begin').show();
        $('#loading').show();
    });
    $(document).on('pjax:complete',
    function() {
        $('#begin').fadeOut();
        $('#loading').delay(100).fadeOut('slow');
        $("body").removeClass('aside-open');
        $(".ham").removeClass('active');
        $("body, html").removeClass('overflow-hidden');
        if ($('.prettyprint').length) {
            window.prettyPrint && prettyPrint();
        };
        ajaxComt();
    });
    $(document).ready(function() {
        $('#begin').fadeOut();
        $('#loading').delay(200).fadeOut('slow');
    });
    $('a[href="#search"]').on('click',
    function(event) {
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
        return false;
    });
    $('#search, #search button.close').on('click keyup',
    function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
	var hide = document.getElementById('toggle-comment-author-info');
    if(!hide) {  
    }else{
    $('#comment-author-info').hide();
    }
	/* ---------------------------------------------- /*
    * 导航下拉框鼠标放上去自动打开，需要的话直接去掉下面两行注释
    /* ---------------------------------------------- */
    //$(".dropdown").mouseover(function(){$(".dropdown-menu").addClass("show");});
	//$(".dropdown").mouseout(function(){$(".dropdown-menu").removeClass("show");});
    /* ---------------------------------------------- */	
    $("#doprofile").click(function(event) {
        var homeUrl = document.location.href.match(/http:\/\/([^\/]+)\//i)[0];
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if ($("#mm_name").val().trim().length == 0) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">请输入昵称</span>");
        } else if (strlen($("#mm_name").val().trim()) < 4) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">昵称长度至少为4位</span>");
        } else if (!reg.test($("#mm_mail").val().trim())) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">法请输入正确邮箱，以免忘记密码时无找回</span>");
        } else {
            $("#doprofile").val("保存中...");
            $('#result').html('<img src="' + homeUrl + '/wp-content/themes/boxmoe/assets/images/loader.gif" class="loader" />').fadeIn();
            $.ajax({
                type: "post",
                //async: false,
                url: homeUrl + "/wp-content/plugins/erphpdown/admin/action/ajax-profile.php",
                data: "do=profile&mm_name=" + $("#mm_name").val() + "&mm_mail=" + $("#mm_mail").val() + "&mm_url=" + $("#mm_url").val() + "&mm_desc=" + $("#mm_desc").val(),
                //contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function(data) {
                    $('.loader').remove();
                    $('#tipsnode').modal();
                    $("#tip1").html("<span class=\"badge badge-success\">恭喜！修改信息成功</span>");
                    $("#doprofile").val("保存");

                },
                error: function() {
                    $('.loader').remove();
                    $('#tipsnode').modal();
                    $("#tip1").html("<span class=\"badge badge-danger\">抱歉！修改失败</span>");
                    $("#doprofile").val("保存");
                }
            });
        }
    });
    $("#dopassword").click(function() {
        var homeUrl = document.location.href.match(/http:\/\/([^\/]+)\//i)[0];
        if ($("#mm_pass_new").val().trim().length == 0) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">请输入新密码</span>");
        } else if (strlen($("#mm_pass_new").val().trim()) < 6) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">密码长度至少为6位</span>");
        } else if ($("#mm_pass_new2").val().trim() != $("#mm_pass_new").val().trim()) {
            $('#tipsnode').modal();
            $("#tip1").html("<span class=\"badge badge-danger\">两次密码不一致</span>");
        } else {
            $('#result').html('<img src="' + homeUrl + '/wp-content/themes/boxmoe/assets/images/loader.gif" class="loader" />').fadeIn();
            $.ajax({
                type: "post",
                //async: false,
                url: homeUrl + "/wp-content/plugins/erphpdown/admin/action/ajax-profile.php",
                data: "do=password&mm_usrname=" + $("#mm_usrname").val() + "&mm_pass_old=" + $("#mm_pass_old").val() + "&mm_pass_new=" + $("#mm_pass_new").val() + "&mm_pass_new2=" + $("#mm_pass_new2").val(),
                //contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function(data) {
                    $('.loader').remove();
                    $('#tipsnode').modal();
                    $("#tip1").html("<span class=\"badge badge-success\">密码修改成功</span>");
                    //alert(data);
                },
                error: function() {
                    $('.loader').remove();
                    $('#tipsnode').modal();
                    $("#tip1").html("<span class=\"badge badge-danger\">密码修改失败</span>");
                }
            });
        }
    });

    function strlen(str) {
        var len = 0;
        for (var i = 0; i < str.length; i++) {
            var c = str.charCodeAt(i);
            if ((c >= 0x0001 && c <= 0x007e) || (0xff60 <= c && c <= 0xff9f)) {
                len++;
            } else {
                len += 2;
            }
        }
        return len;
    }
    /* ---------------------------------------------- /*
    * tooltip
    /* ---------------------------------------------- */

    $('[data-toggle="tooltip"]').tooltip();

    /* ---------------------------------------------- /*
    * lolijump
    /* ---------------------------------------------- */
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 100) {
            $("#lolijump").fadeIn();
        } else {

            $("#lolijump").fadeOut();
        }
    });
    $("#lolijump").click(function(event) {
        $('html,body').animate({
            scrollTop: 0
        },
        500);
        return false;
    });
    /* ---------------------------------------------- /*
    * prettyPrint
    /* ---------------------------------------------- */
    if ($('.prettyprint').length) {
        window.prettyPrint && prettyPrint();
    }

    /* ---------------------------------------------- /*
    * Popover
    /* ---------------------------------------------- */
    $('[data-toggle="popover"]').each(function() {
        var popoverClass = '';
        if ($(this).data('color')) {
            popoverClass = 'popover-' + $(this).data('color');
        }
        $(this).popover({
            trigger: 'focus',
            template: '<div class="popover ' + popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        })
    });
    /* ---------------------------------------------- /*
    * Additional .focus class on form-groups
    /* ---------------------------------------------- */
    $('.form-control').on('focus blur',
    function(e) {
        $(this).parents('.comment-form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');

    /* ---------------------------------------------- /*
    * input-slider-range
    /* ---------------------------------------------- */

    if ($("#input-slider-range")[0]) {
        var c = document.getElementById("input-slider-range"),
        d = document.getElementById("input-slider-range-value-low"),
        e = document.getElementById("input-slider-range-value-high"),
        f = [d, e];

        noUiSlider.create(c, {
            start: [parseInt(d.getAttribute('data-range-value-low')), parseInt(e.getAttribute('data-range-value-high'))],
            connect: !0,
            range: {
                min: parseInt(c.getAttribute('data-range-value-min')),
                max: parseInt(c.getAttribute('data-range-value-max'))
            }
        }),
        c.noUiSlider.on("update",
        function(a, b) {
            f[b].textContent = a[b]
        })
    }

    /* ---------------------------------------------- /*
    * viewport
    /* ---------------------------------------------- */
    $('[data-toggle="on-screen"]')[0] && $('[data-toggle="on-screen"]').onScreen({
        container: window,
        direction: 'vertical',
        doIn: function() {
            //alert();
        },
        doOut: function() {},
        tolerance: 200,
        throttle: 50,
        toggleClass: 'on-screen',
        debug: false
    });

    $('[data-toggle="scroll"]').on('click',
    function(event) {
        var hash = $(this).attr('href');
        var offset = $(this).data('offset') ? $(this).data('offset') : 0;

        // Animate scroll to the selected section
        $('html, body').stop(true, true).animate({
            scrollTop: $(hash).offset().top - offset
        },
        600);

        event.preventDefault();
    });

    /* ---------------------------------------------- /*
    * Section Scroll - Navbar
    /* ---------------------------------------------- */

    $('.navbar-toggler').on('click',
    function() {
        $('html, body').animate({
            scrollTop: 0
        });
        $("body").toggleClass('aside-open');
        $(".ham").toggleClass('active');
        $("body, html").toggleClass('overflow-hidden');
    });

    /* ---------------------------------------------- /*
    * Scroll Spy - init
    /* ---------------------------------------------- */

    $("#navbarCollapse").scrollspy({
        offset: 20
    });

    /* ---------------------------------------------- /*
    * AnimateOnScroll - Init
    /* ---------------------------------------------- */

    var wow = new WOW({
        boxClass: 'wow',
        // animated element css class (default is wow)
        animateClass: 'animated',
        // animation css class (default is animated)
        offset: 0,
        // distance to the element when triggering the animation (default is 0)
        mobile: true,
        // trigger animations on mobile devices (default is true)
        live: true,
        // act on asynchronously loaded content (default is true)
        callback: function(box) {
            // the callback is fired every time an animation is started
            // the argument that is passed in is the DOM node being animated
        },
        scrollContainer: null,
        // optional scroll container selector, otherwise use window,
        resetAnimation: true,
        // reset animation on end (default is true)
    });
    wow.init();

    /* ---------------------------------------------- /*
    * Initialize shuffle plugin
    /* ---------------------------------------------- */

    var $portfolioContainer = $('.list-items-container');

    $('#filter li').on('click',
    function(e) {
        e.preventDefault();

        $('#filter li').removeClass('active');
        $(this).addClass('active');

        var group = $(this).attr('data-group');
        var groupName = $(this).attr('data-group');

        $portfolioContainer.shuffle('shuffle', groupName);
    });

    /* ---------------------------------------------- /*
    * Parallax - Init
    /* ---------------------------------------------- */

    $(".js-height-full").height($(window).height());

    $(window).resize(function() {
        $(".js-height-full").height($(window).height());
    });

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        $('#home').css({
            'background-attachment': 'scroll'
        });
    } else {
        $('#home').parallax('50%', -0.3);
    }

    if ($('.section-home').length) {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $('.swiper-slide').css({
                'background-attachment': 'scroll'
            });
        } else {
            $('.swiper-slide').parallax('50%', -0.3);
        }
    }

} (window.jQuery);