<script type="text/javascript">
    function lst_restart() {
        $.SmartMessageBox({
            title: "<i class='fa fa-lg fa-repeat txt-color-green'></i> <span class='text-warning'><strong><?php DMsg::EchoUIStr('service_restartconfirm') ?></strong></span>",
            buttons: '<?php echo '[' . DMsg::UIStr('btn_cancel') . '][' . DMsg::UIStr('btn_go') . ']' ; ?>'
        }, function (ButtonPressed) {
            if (ButtonPressed === "<?php DMsg::EchoUIStr('btn_go') ?>") {
                $.ajax({
                    type: "POST",
                    url: "view/serviceMgr.php",
                    data: {"act": "restart"},
                    beforeSend: function () {
                        $.smallBox({
                            title: "<?php DMsg::EchoUIStr('service_requesting') ?>",
                            content: "<i class='fa fa-clock-o'></i> <i><?php DMsg::EchoUIStr('service_willrefresh') ?></i>",
                            color: "#659265",
                            iconSmall: "fa fa-check fa-2x fadeInRight animated",
                            timeout: 15000
                        });
                    },
                    success: function (data) {
                        location.reload(true);
                    }
                });
            }
        });
    }

    function lst_toggledebug() {
        $.SmartMessageBox({
            title: "<i class='fa fa-lg fa-bug txt-color-red'></i> <span class='text-warning'><strong><?php DMsg::EchoUIStr('service_toggledebug') ?></strong></span>",
            content: "<?php DMsg::EchoUIStr('service_toggledebugmsg') ?>",
            buttons: '<?php echo '[' . DMsg::UIStr('btn_cancel') . '][' . DMsg::UIStr('btn_go') . ']' ; ?>'
        }, function (ButtonPressed) {
            if (ButtonPressed === "<?php DMsg::EchoUIStr('btn_go') ?>") {
                $.ajax({
                    type: "POST",
                    url: "view/serviceMgr.php",
                    data: {"act": "toggledebug"},
                    beforeSend: function () {
                        $.smallBox({
                            title: "<?php DMsg::EchoUIStr('service_requesting') ?>",
                            content: "<i class='fa fa-clock-o'></i> <i><?php DMsg::EchoUIStr('service_willrefresh') ?></i>",
                            color: "#659265",
                            iconSmall: "fa fa-check fa-2x fadeInRight animated",
                            timeout: 2200
                        });
                    },
                    success: function (data) {
                        setTimeout(refreshLog, 2000);
                    }
                });
            }
        });
    }
</script>

<!-- IMPORTANT: APP CONFIG -->
<script src="/res/js/app.config.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="/res/js/bootstrap/bootstrap.min.js"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="/res/js/notification/SmartNotification.min.js"></script>

<!-- browser msie issue fix -->
<script src="/res/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!--[if IE 8]>
    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->

<!-- MAIN APP JS FILE -->
<!-- <script src="/res/js/lst-app.min.js"></script> -->

<script type="text/javascript">
    $.root_ = $("body");
    $.intervalArr = [];
    var calc_navbar_height = function() {
    		var a = null;
    		if ($("#header").length) {
    			a = $("#header").height()
    		}
    		if (a === null) {
    			a = $('<div id="header"></div>').height()
    		}
    		if (a === null) {
    			return 49
    		}
    		return a
    	},
    	navbar_height = calc_navbar_height,
    	shortcut_dropdown = $("#shortcut"),
    	bread_crumb = $("#ribbon ol.breadcrumb"),
    	thisDevice = null,
    	ismobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase())),
    	jsArray = {},
    	initApp = (function(a) {
    		a.addDeviceType = function() {
    			if (!ismobile) {
    				$.root_.addClass("desktop-detected");
    				thisDevice = "desktop";
    				return false
    			} else {
    				$.root_.addClass("mobile-detected");
    				thisDevice = "mobile"
    			}
    		};
    		a.SmartActions = function() {
    			var b = {
    				userLogout: function(d) {
    					$.SmartMessageBox({
    						title: "<i class='fa fa-sign-out txt-color-orangeDark'></i> <?php DMsg::EchoUIStr('note_confirm_logout') ?> <span class='txt-color-orangeDark'><strong>" + $("#show-shortcut").text() + "</strong></span> ?",
    						content: "<?php DMsg::EchoUIStr('note_logout') ?>",
    						buttons: '<?php echo '[' . DMsg::UIStr('btn_cancel') . '][' . DMsg::UIStr('btn_go') . ']' ; ?>'
    					}, function(e) {
    						if (e === "<?php DMsg::EchoUIStr('btn_go') ?>") {
    							$.root_.addClass("animated fadeOutUp");
    							setTimeout(c, 1000)
    						}
    					});

    					function c() {
    						window.location = d.attr("href")
    					}
    				},
    				launchFullscreen: function(c) {
    					if (!$.root_.hasClass("full-screen")) {
    						$.root_.addClass("full-screen");
    						if (c.requestFullscreen) {
    							c.requestFullscreen()
    						} else {
    							if (c.mozRequestFullScreen) {
    								c.mozRequestFullScreen()
    							} else {
    								if (c.webkitRequestFullscreen) {
    									c.webkitRequestFullscreen()
    								} else {
    									if (c.msRequestFullscreen) {
    										c.msRequestFullscreen()
    									}
    								}
    							}
    						}
    					} else {
    						$.root_.removeClass("full-screen");
    						if (document.exitFullscreen) {
    							document.exitFullscreen()
    						} else {
    							if (document.mozCancelFullScreen) {
    								document.mozCancelFullScreen()
    							} else {
    								if (document.webkitExitFullscreen) {
    									document.webkitExitFullscreen()
    								}
    							}
    						}
    					}
    				},
    				minifyMenu: function(c) {
    					if (!$.root_.hasClass("menu-on-top")) {
    						$.root_.toggleClass("minified");
    						$.root_.removeClass("hidden-menu");
    						$("html").removeClass("hidden-menu-mobile-lock");
    						c.effect("highlight", {}, 500)
    					}
    				},
    				toggleMenu: function() {
    					if (!$.root_.hasClass("menu-on-top")) {
    						$("html").toggleClass("hidden-menu-mobile-lock");
    						$.root_.toggleClass("hidden-menu");
    						$.root_.removeClass("minified")
    					} else {
    						if ($.root_.hasClass("menu-on-top") && $.root_.hasClass("mobile-view-activated")) {
    							$("html").toggleClass("hidden-menu-mobile-lock");
    							$.root_.toggleClass("hidden-menu");
    							$.root_.removeClass("minified")
    						}
    					}
    				},
    				toggleShortcut: function() {
    					if (shortcut_dropdown.is(":visible")) {
    						d()
    					} else {
    						c()
    					}
    					shortcut_dropdown.find('a[href^="#"]').click(function(f) {
    						f.preventDefault();
    						window.location = $(this).attr("href");
    						setTimeout(d, 300)
    					});
    					$(document).mouseup(function(f) {
    						if (!shortcut_dropdown.is(f.target) && shortcut_dropdown.has(f.target).length === 0) {
    							d()
    						}
    					});

    					function d() {
    						shortcut_dropdown.animate({
    							height: "hide"
    						}, 300, "easeOutCirc");
    						$.root_.removeClass("shortcut-on")
    					}

    					function c() {
    						shortcut_dropdown.animate({
    							height: "show"
    						}, 200, "easeOutCirc");
    						$.root_.addClass("shortcut-on")
    					}
    				}
    			};
    			$.root_.on("click", '[data-action="userLogout"]', function(d) {
    				var c = $(this);
    				b.userLogout(c);
    				d.preventDefault();
    				c = null
    			});
    			$.root_.on("click", '[data-action="launchFullscreen"]', function(c) {
    				b.launchFullscreen(document.documentElement);
    				c.preventDefault()
    			});
    			$.root_.on("click", '[data-action="minifyMenu"]', function(d) {
    				var c = $(this);
    				b.minifyMenu(c);
    				d.preventDefault();
    				c = null
    			});
    			$.root_.on("click", '[data-action="toggleMenu"]', function(c) {
    				b.toggleMenu();
    				c.preventDefault()
    			});
    			$.root_.on("click", '[data-action="toggleShortcut"]', function(c) {
    				b.toggleShortcut();
    				c.preventDefault()
    			})
    		};
    		a.leftNav = function() {
    			if (!null) {
    				$("nav ul").jarvismenu({
    					accordion: true,
    					speed: menu_speed,
    					closedSign: '<em class="fa fa-plus-square-o"></em>',
    					openedSign: '<em class="fa fa-minus-square-o"></em>'
    				})
    			} else {
    				alert("<?php DMsg::EchoUIStr('err_menuanchornotexist') ?>")
    			}
    		};
    		a.domReadyMisc = function() {
    			if ($("[rel=tooltip]").length) {
    				$("[rel=tooltip]").tooltip()
    			}
    		};
    		return a
    	})({});
    initApp.addDeviceType();
    jQuery(document).ready(function() {
    	initApp.SmartActions();
    	initApp.leftNav();
    	initApp.domReadyMisc()
    });
    (function(g, i, c) {
    	var a = g([]),
    		e = g.resize = g.extend(g.resize, {}),
    		j, l = "setTimeout",
    		k = "resize",
    		d = k + "-special-event",
    		b = "delay",
    		f = "throttleWindow";
    	e[b] = throttle_delay;
    	e[f] = true;
    	g.event.special[k] = {
    		setup: function() {
    			if (!e[f] && this[l]) {
    				return false
    			}
    			var m = g(this);
    			a = a.add(m);
    			try {
    				g.data(this, d, {
    					w: m.width(),
    					h: m.height()
    				})
    			} catch (n) {
    				g.data(this, d, {
    					w: m.width,
    					h: m.height
    				})
    			}
    			if (a.length === 1) {
    				h()
    			}
    		},
    		teardown: function() {
    			if (!e[f] && this[l]) {
    				return false
    			}
    			var m = g(this);
    			a = a.not(m);
    			m.removeData(d);
    			if (!a.length) {
    				clearTimeout(j)
    			}
    		},
    		add: function(m) {
    			if (!e[f] && this[l]) {
    				return false
    			}
    			var o;

    			function n(t, p, q) {
    				var r = g(this),
    					s = g.data(this, d);
    				s.w = p !== c ? p : r.width();
    				s.h = q !== c ? q : r.height();
    				o.apply(this, arguments)
    			}
    			if (g.isFunction(m)) {
    				o = m;
    				return n
    			} else {
    				o = m.handler;
    				m.handler = n
    			}
    		}
    	};

    	function h() {
    		j = i[l](function() {
    			a.each(function() {
    				var n;
    				var m;
    				var o = g(this),
    					p = g.data(this, d);
    				try {
    					n = o.width()
    				} catch (q) {
    					n = o.width
    				}
    				try {
    					m = o.height()
    				} catch (q) {
    					m = o.height
    				}
    				if (n !== p.w || m !== p.h) {
    					o.trigger(k, [p.w = n, p.h = m])
    				}
    			});
    			h()
    		}, e[b])
    	}
    })(jQuery, this);
    $("#main").resize(function() {
    	if ($(window).width() < 979) {
    		$.root_.addClass("mobile-view-activated");
    		$.root_.removeClass("minified")
    	} else {
    		if ($.root_.hasClass("mobile-view-activated")) {
    			$.root_.removeClass("mobile-view-activated")
    		}
    	}
    });
    var ie = (function() {
    	var c, a = 3,
    		d = document.createElement("div"),
    		b = d.getElementsByTagName("i");
    	while (d.innerHTML = "<!--[if gt IE " + (++a) + "]><i></i><![endif]-->", b[0]) {}
    	return a > 4 ? a : c
    }());
    $.fn.extend({
    	jarvismenu: function(a) {
    		var d = {
    				accordion: "true",
    				speed: 200,
    				closedSign: "[+]",
    				openedSign: "[-]"
    			},
    			b = $.extend(d, a),
    			c = $(this);
    		c.find("li").each(function() {
    			if ($(this).find("ul").size() !== 0) {
    				$(this).find("a:first").append("<b class='collapse-sign'>" + b.closedSign + "</b>");
    				if ($(this).find("a:first").attr("href") == "#") {
    					$(this).find("a:first").click(function() {
    						return false
    					})
    				}
    			}
    		});
    		c.find("li.active").each(function() {
    			$(this).parents("ul").slideDown(b.speed);
    			$(this).parents("ul").parent("li").find("b:first").html(b.openedSign);
    			$(this).parents("ul").parent("li").addClass("open")
    		});
    		c.find("li a").click(function() {
    			if ($(this).parent().find("ul").size() !== 0) {
    				if (b.accordion) {
    					if (!$(this).parent().find("ul").is(":visible")) {
    						parents = $(this).parent().parents("ul");
    						visible = c.find("ul:visible");
    						visible.each(function(e) {
    							var f = true;
    							parents.each(function(g) {
    								if (parents[g] == visible[e]) {
    									f = false;
    									return false
    								}
    							});
    							if (f) {
    								if ($(this).parent().find("ul") != visible[e]) {
    									$(visible[e]).slideUp(b.speed, function() {
    										$(this).parent("li").find("b:first").html(b.closedSign);
    										$(this).parent("li").removeClass("open")
    									})
    								}
    							}
    						})
    					}
    				}
    				if ($(this).parent().find("ul:first").is(":visible") && !$(this).parent().find("ul:first").hasClass("active")) {
    					$(this).parent().find("ul:first").slideUp(b.speed, function() {
    						$(this).parent("li").removeClass("open");
    						$(this).parent("li").find("b:first").delay(b.speed).html(b.closedSign)
    					})
    				} else {
    					$(this).parent().find("ul:first").slideDown(b.speed, function() {
    						$(this).parent("li").addClass("open");
    						$(this).parent("li").find("b:first").delay(b.speed).html(b.openedSign)
    					})
    				}
    			}
    		})
    	}
    });
    jQuery.fn.doesExist = function() {
    	return jQuery(this).length > 0
    };

    function loadScript(c, d) {
    	if (!jsArray[c]) {
    		jsArray[c] = true;
    		var a = document.getElementsByTagName("body")[0],
    			b = document.createElement("script");
    		b.type = "text/javascript";
    		b.src = c;
    		b.onload = d;
    		a.appendChild(b)
    	} else {
    		if (d) {
    			d()
    		}
    	}
    }
    if ($.navAsAjax) {
    	if ($("nav").length) {
    		checkURL()
    	}
    	$(document).on("click", 'nav a[href!="#"]', function(b) {
    		b.preventDefault();
    		var a = $(b.currentTarget);
    		if (!a.attr("target")) {
    			if (!a.parent().hasClass("active")) {
    				if ($.root_.hasClass("mobile-view-activated")) {
    					$.root_.removeClass("hidden-menu");
    					$("html").removeClass("hidden-menu-mobile-lock");
    					window.setTimeout(function() {
    						if (window.location.search) {
    							window.location.href = window.location.href.replace(window.location.search, "").replace(window.location.hash, "") + "#" + a.attr("href")
    						} else {
    							window.location.hash = a.attr("href")
    						}
    					}, 150)
    				} else {
    					if (window.location.search) {
    						window.location.href = window.location.href.replace(window.location.search, "").replace(window.location.hash, "") + "#" + a.attr("href")
    					} else {
    						window.location.hash = a.attr("href")
    					}
    				}
    			} else {
    				if (window.location.hash != a.attr("href")) {
    					window.location.hash = a.attr("href")
    				}
    			}
    		}
    	});
    	$(document).on("click", 'nav a[target="_blank"]', function(b) {
    		b.preventDefault();
    		var a = $(b.currentTarget);
    		window.open(a.attr("href"))
    	});
    	$(document).on("click", 'nav a[target="_top"]', function(b) {
    		b.preventDefault();
    		var a = $(b.currentTarget);
    		window.location = (a.attr("href"))
    	});
    	$(document).on("click", 'nav a[href="#"]', function(a) {
    		a.preventDefault()
    	});
    	$(window).on("hashchange", function() {
    		checkURL()
    	})
    }

    function checkURL() {
    	var d = location.href.indexOf("#");
    	var c = location.href.indexOf("_");
    	if (c == -1) {
    		c = location.href.indexOf("&")
    	}
    	var b = location.href.split("#").splice(1).join("#");
    	if (!b) {
    		try {
    			var f = window.document.URL;
    			if (f) {
    				if (f.indexOf("#", 0) > 0 && f.indexOf("#", 0) < (f.length + 1)) {
    					b = f.substring(f.indexOf("#", 0) + 1)
    				}
    			}
    		} catch (e) {}
    	}
    	var a = b;
    	if (d != -1 && c != -1) {
    		a = location.href.substring(d + 1, c)
    	}
    	container = $("#content");
    	if (b) {
    		$("nav li.active").removeClass("active");
    		$('nav li:has(a[href="' + a + '"])').addClass("active");
    		var h = ($('nav a[href="' + a + '"]').attr("title"));
    		document.title = (h || document.title);
    		loadURL(b + location.search, container)
    	} else {
    		var g = $('nav > ul > li:first-child > a[href!="#"]');
    		window.location.hash = g.attr("href");
    		g = null
    	}
    }

    function loadURL(b, a) {
    	$.ajax({
    		type: "GET",
    		url: b,
    		dataType: "html",
    		cache: true,
    		beforeSend: function() {
    			if ($.navAsAjax && $(".dataTables_wrapper")[0] && (a[0] == $("#content")[0])) {
    				var c = $.fn.dataTable.fnTables(true);
    				$(c).each(function() {
    					$(this).dataTable().fnDestroy()
    				})
    			}
    			if ($.navAsAjax && $.intervalArr.length > 0 && (a[0] == $("#content")[0])) {
    				while ($.intervalArr.length > 0) {
    					clearInterval($.intervalArr.pop())
    				}
    			}
    			pagefunction = null;
    			a.removeData();
    			if (a[0] == $("#content")[0]) {
    				$("body").find("> *").filter(":not(" + ignore_key_elms + ")").empty().remove();
    				drawBreadCrumb()
    			}
    		},
    		success: function(c) {
    			if (c == '{"login_timeout":1}') {
    				window.location.href = "/login.php?timedout=1"
    			} else {
    				a.html(c);
    				c = null;
    				a = null
    			}
    		},
    		error: function(e, c, d) {
    			a.html('<h4 class="ajax-loading-error"><i class="fa fa-warning txt-color-orangeDark"></i> <?php DMsg::EchoUIStr('err_page_404') ?></h4>')
    		},
    		async: true
    	})
    }

    function drawBreadCrumb() {
    	var b = $("nav li.active > a"),
    		a = b.length;
    	bread_crumb.empty();
    	bread_crumb.append($("<li><?php DMsg::EchoUIStr('note_home') ?></li>"));
    	b.each(function() {
    		bread_crumb.append($("<li></li>").html($.trim($(this).clone().children(".badge").remove().end().text())));
    		if (!--a) {
    			document.title = bread_crumb.find("li:last-child").text()
    		}
    	});
    	b = null
    }

    function lst_conf(c, f, d, e) {
    	if (c) {
    		$("input[name=a]").val(c)
    	}
    	if (f) {
    		$("input[name=p]").val(f)
    	}
    	if (d) {
    		$("input[name=t]").val((d == "-") ? "" : d)
    	}
    	if (e) {
    		$("input[name=r]").val((e == "-") ? "" : e)
    	}
    	if (c == "v" && f != "" && d == "-" && e == "-") {
    		var b = window.location.hash.indexOf("&p=");
    		if (b == -1) {
    			window.location.hash += "&p=" + f
    		} else {
    			if (f != window.location.hash.substring(b + 3)) {
    				window.location.hash = window.location.hash.substring(0, b + 3) + f
    			}
    		}
    		return
    	}
    	$.ajax({
    		type: "POST",
    		url: "view/confMgr.php",
    		data: $("#confform").serialize(),
    		dataType: "html",
    		beforeSend: function() {
    			if ($.navAsAjax && $(".dataTables_wrapper")[0] && (container[0] == $("#content")[0])) {
    				var a = $.fn.dataTable.fnTables(true);
    				$(a).each(function() {
    					$(this).dataTable().fnDestroy()
    				})
    			}
    			pagefunction = null;
    			$("#content").removeData()
    		},
    		success: function(a) {
    			if (a == '{"login_timeout":1}') {
    				window.location.href = "/login.php?timedout=1"
    			} else {
    				$("#content").html(a);
    				a = null;
    				pageSetUp()
    			}
    		},
    		error: function(h, a, g) {
    			$("#content").html('<h4 class="ajax-loading-error"><i class="fa fa-warning txt-color-orangeDark"></i> <?php DMsg::EchoUIStr('err_page_404') ?></h4>')
    		},
    	})
    }

    function lst_ctxseq(a) {
    	$("#confform").prepend('<input type="hidden" name="ctxseq" value="' + a + '">');
    	lst_conf()
    }

    function lst_refreshFooterTime() {
    	$("#lst_UpdateStamp").text(new Date().toLocaleString())
    }

    function lst_createFile(b) {
    	$("#confform").prepend('<input type="hidden" name="file_create" value="' + b + '">');
    	lst_conf("s")
    }

    function refresh_load() {
    	var a = $("#sparks");
    	if (a.length) {
    		$.ajax({
    			url: "view/ajax_data.php?id=pid_load",
    			type: "GET",
    			dataType: "json",
    			success: function(b) {
    				if (b.hasOwnProperty("login_timeout")) {
    					window.location.href = "/login.php?timedout=1"
    				} else {
    					a.find("#lst-pid").text(b.pid);
    					a.find("#lst-load").text(b.serverload);
    					lst_refreshFooterTime();
    					setTimeout(refresh_load, 60000)
    				}
    			}
    		})
    	}
    }
    setTimeout(refresh_load, 60000);

    function pageSetUp() {
    	if (thisDevice === "desktop") {
    		$("[rel=tooltip]").tooltip();
    		$("[rel=popover]").popover();
    		$("[rel=popover-hover]").popover({
    			trigger: "hover"
    		})
    	} else {
    		$("[rel=popover]").popover();
    		$("[rel=popover-hover]").popover({
    			trigger: "hover"
    		})
    	}
    	$("#lst-lang").find("li").on("click", function(a) {
    		$.ajax({
    			type: "POST",
    			url: "view/serviceMgr.php",
    			data: {
    				"act": "lang",
    				"actId": $(this).data("lang")
    			},
    			success: function() {
    				location.reload(true)
    			}
    		})
    	});
    	lst_refreshFooterTime()
    }
    $("body").on("click", function(a) {
    	$('[rel="popover"]').each(function() {
    		if (!$(this).is(a.target) && $(this).has(a.target).length === 0 && $(".popover").has(a.target).length === 0) {
    			$(this).popover("hide")
    		}
    	})
    });

    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    $(document).ready(function () {
        pageSetUp();
    });
</script>
