/* ===================================================================
    
    Author          : Valid Theme
    Template Name   : Markia - SEO & Digital Marketing Agency Template
    Version         : 1.0
    
* ================================================================= */
(function($) {
	"use strict";

	$(document).ready(function() {


		/* ==================================================
		    # Wow active
		===============================================*/
		if ($(".wow").length) {
			var wow = new WOW({
				boxClass: "wow", // animated element css class (default is wow)
				animateClass: "animated", // animation css class (default is animated)
				mobile: true, // trigger animations on mobile devices (default is true)
				live: true // act on asynchronously loaded content (default is true)
			});
			wow.init();
		}

		/* ==================================================
		    # Youtube Video Init
		 ===============================================*/
		$('.player').mb_YTPlayer();


		/* ==================================================
            # imagesLoaded active
        ===============================================*/
		$('#portfolio-grid,.blog-masonry').imagesLoaded(function() {

			/* Filter menu */
			$('.mix-item-menu').on('click', 'button', function() {
				var filterValue = $(this).attr('data-filter');
				$grid.isotope({
					filter: filterValue
				});
			});

			/* filter menu active class  */
			$('.mix-item-menu button').on('click', function(event) {
				$(this).siblings('.active').removeClass('active');
				$(this).addClass('active');
				event.preventDefault();
			});

			/* Filter active */
			var $grid = $('#portfolio-grid').isotope({
				itemSelector: '.pf-item',
				percentPosition: true,
				masonry: {
					columnWidth: '.pf-item',
				}
			});

			/* Filter active */
			$('.blog-masonry').isotope({
				itemSelector: '.blog-item',
				percentPosition: true,
				masonry: {
					columnWidth: '.blog-item',
				}
			});

		});


		/* ==================================================
		    # Fun Factor Init
		===============================================*/
		$('.js-counter').numberAnimate();


		/* ==================================================
		    # Preloader Prepend
		===============================================*/
		$('#validthemes-loader').prepend($('<div class="loader-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'));


		/* ==================================================
            # Hover Active Init
        ===============================================*/
		$('.hover-active-item').on('mouseenter', function() {
			var $this;
			$this = $(this);
			if ($this.hasClass('active')) {
				$this.addClass('active');
			} else {
				$this.addClass('active');
				$this.siblings().removeClass('active');
			}
		})


		/* ==================================================
		    Circle Text
		================================================== */
		let circleTypeElm = $(".circle-text-item");
		if (circleTypeElm.length) {
			circleTypeElm.each(function() {
				let elm = $(this);
				let options = elm.data("circle-text-options");
				elm.circleType(
					"object" === typeof options ? options : JSON.parse(options)
				);
			});
		}

		/* ==================================================
		    # Magnific popup init
		 ===============================================*/
		$(".popup-link").magnificPopup({
			type: 'image',
			// other options
		});

		$(".popup-gallery").magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			},
			// other options
		});

		$(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
			type: "iframe",
			mainClass: "mfp-fade",
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});

		$('.magnific-mix-gallery').each(function() {
			var $container = $(this);
			var $imageLinks = $container.find('.item');

			var items = [];
			$imageLinks.each(function() {
				var $item = $(this);
				var type = 'image';
				if ($item.hasClass('magnific-iframe')) {
					type = 'iframe';
				}
				var magItem = {
					src: $item.attr('href'),
					type: type
				};
				magItem.title = $item.data('title');
				items.push(magItem);
			});

			$imageLinks.magnificPopup({
				mainClass: 'mfp-fade',
				items: items,
				gallery: {
					enabled: true,
					tPrev: $(this).data('prev-text'),
					tNext: $(this).data('next-text')
				},
				type: 'image',
				callbacks: {
					beforeOpen: function() {
						var index = $imageLinks.index(this.st.el);
						if (-1 !== index) {
							this.goTo(index);
						}
					}
				}
			});
		});


		/* ==================================================
            # Brand Carousel
         ===============================================*/
		const brandCarousel = new Swiper(".brand-style-one-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			pagination: {
				el: ".brand-style-three-pagination",
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: ".brand-swiper-button-next",
				prevEl: ".brand-swiper-button-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				1400: {
					slidesPerView: 5,
					centeredSlides: true,

				},
			}
		});

		/* ==================================================
            # Services Three Carousel
         ===============================================*/
		const serviceThreeCarousel = new Swiper(".service-style-three-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			pagination: {
				el: ".service-style-three-pagination",
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: ".service-swiper-button-next",
				prevEl: ".service-swiper-button-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				1400: {
					slidesPerView: 3.9,
					centeredSlides: true,

				},
			}
		});


		/* ==================================================
            # Portfolio One Carousel
         ===============================================*/
		const portfoliOneCarousel = new Swiper(".portfolio-style-one-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			pagination: {
				el: ".portfolio-style-one-pagination",
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: ".testimonial-swiper-button-next",
				prevEl: ".testimonial-swiper-button-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				1400: {
					slidesPerView: 2,
					centeredSlides: true,

				},
			}
		});

		/* ==================================================
            # Portfolio Two Carousel
         ===============================================*/
		const portfolioTwoCarousel = new Swiper(".portfolio-style-two-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 0,
			autoplay: false,
			pagination: {
				el: ".portfolio-style-two-pagination",
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: ".portfolio-two-next",
				prevEl: ".portfolio-two-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				1400: {
					slidesPerView: 3,

				},
			}
		});


		/* ==================================================
            # Blog Carousel
         ===============================================*/
		const blogCarousel = new Swiper(".blog-style-one-carousel", {
			// Optional parameters
			loop: true,
			freeMode: true,
			grabCursor: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			// If we need pagination
			pagination: {
				el: '.blog-one-pagination',
				type: 'fraction',
				clickable: true,
			},

			// Navigation arrows
			navigation: {
				nextEl: ".blog-one-next",
				prevEl: ".blog-one-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
					spaceBetween: 30,
				},
				992: {
					slidesPerView: 2,
					spaceBetween: 30,
				},
				1250: {
					slidesPerView: 1.8,
					spaceBetween: 30,
				},
			},
		});


		/* ==================================================
            # Testimonial One Carousel
         ===============================================*/
		const testimonialOneCarousel = new Swiper(".testimonial-style-one-carousel", {
			// Optional parameters
			loop: true,
			freeMode: true,
			grabCursor: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			breakpoints: {
				1200: {
					slidesPerView: 2,
					spaceBetween: 30,
				}
			},
		});


		/* ==================================================
            # Testimonial Two Carousel
         ===============================================*/
		const testimonialTwoCarousel = new Swiper(".testimonial-style-two-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 80,
			autoplay: false,
			pagination: {
				el: ".testimonial-style-two-pagination",
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: ".testimonial-two-next",
				prevEl: ".testimonial-two-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 1,
				},
				1400: {
					slidesPerView: 1,

				},
			}
		});


		/* ==================================================
            # Testimonial Three Carousel
         ===============================================*/
		const testimonialThreeCarousel = new Swiper(".testimonial-style-three-carousel", {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			autoplay: false,
			// Navigation arrows
			navigation: {
				nextEl: ".testimonial-three-next",
				prevEl: ".testimonial-three-prev"
			},
			breakpoints: {
				768: {
					slidesPerView: 1,
				},
				1400: {
					slidesPerView: 2,

				},
			}
		});


		/* ==================================================
        	# Text Scroll Animation
        ===============================================*/
		var width = $(window).width();
		if (width > 991) {
			let text_scroll = document.querySelector(".text-scroll-animation");
			if (text_scroll) {
				gsap.registerPlugin(ScrollTrigger);
				const textElements = gsap.utils.toArray('.text');
				textElements.forEach(text => {
					gsap.to(text, {
						backgroundSize: '100%',
						ease: 'none',
						scrollTrigger: {
							trigger: text,
							start: 'center 100%',
							end: 'center 50%',
							scrub: true,
						},
					});
				});
			}
		}

		
		/* ==================================================
		    Splite Text
		================================================== */

		var width = $(window).width();
		if (width > 991) {
			let text_split = document.querySelector(".split-text");
			if (text_split) {
				const animEls = document.querySelectorAll('.split-text');
				animEls.forEach(el => {
					var splitEl = new SplitText(el, {
						type: "lines, words",
						linesClass: "line"
					});
					var splitTl = gsap.timeline({
						duration: .35,
						ease: 'power4',
						scrollTrigger: {
							trigger: el,
							start: 'top 100%'
						}
					});

					splitTl.from(splitEl.words, {
						yPercent: "100",
						stagger: 0.025,
					});

				});
			}
		}
		

		/* ==================================================
		    Contact Form Validations
		================================================== */
		$('.contact-form').each(function() {
			var formInstance = $(this);
			formInstance.submit(function() {

				var action = $(this).attr('action');

				$("#message").slideUp(750, function() {
					$('#message').hide();

					$('#submit')
						.after('<img src="assets/img/ajax-loader.gif" class="loader" />')
						.attr('disabled', 'disabled');

					$.post(action, {
							name: $('#name').val(),
							email: $('#email').val(),
							phone: $('#phone').val(),
							comments: $('#comments').val()
						},
						function(data) {
							document.getElementById('message').innerHTML = data;
							$('#message').slideDown('slow');
							$('.contact-form img.loader').fadeOut('slow', function() {
								$(this).remove()
							});
							$('#submit').removeAttr('disabled');
						}
					);
				});
				return false;
			});
		});

	}); // end document ready function

	/* Preloader */
	$(window).on('load', function() {
        jQuery('#validthemes-loader').fadeOut(500);
    });

})(jQuery); // End jQuery