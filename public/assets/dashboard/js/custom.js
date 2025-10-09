// document.getElementById('view-more-btn').addEventListener('click', function() {
//     const moreServices = document.getElementById('more-services');

//     moreServices.classList.toggle('d-none');

//     if (moreServices.classList.contains('d-none')) {
//         this.textContent = 'View All Services'; 
//     } else {
//         this.textContent = 'Show Less'
//     }
// }); //added by muhammed 28/9

(function ($) {
    "use strict";

    // Mouse cursor design
    // var cursor = document.querySelector('.cursor');
    // var cursorinner = document.querySelector('.cursor2');
    // var a = document.querySelectorAll('a');

    // document.addEventListener('mousemove', function (e) {
    //     var x = e.clientX;
    //     var y = e.clientY;
    //     cursor.style.transform = `translate3d(calc(${e.clientX}px - 50%), calc(${e.clientY}px - 50%), 0)`
    // });

    // $('a').hover(
    //     function () {
    //         $('.cursor2').css({
    //             "background-color": "transparent"
    //         });
    //     },
    //     function () {
    //         $('.cursor2').css({
    //             "background-color": "#0061ae"
    //         });
    //     }
    // );

    // document.addEventListener('mousemove', function (e) {
    //     var x = e.clientX;
    //     var y = e.clientY;
    //     cursorinner.style.left = x + 'px';
    //     cursorinner.style.top = y + 'px';
    // });

    // document.addEventListener('mousedown', function () {
    //     cursor.classList.add('click');
    //     cursorinner.classList.add('cursorinnerhover')
    // });

    // document.addEventListener('mouseup', function () {
    //     cursor.classList.remove('click')
    //     cursorinner.classList.remove('cursorinnerhover')
    // });

    // a.forEach(item => {
    //     item.addEventListener('mouseover', () => {
    //         cursor.classList.add('hover');
    //     });
    //     item.addEventListener('mouseleave', () => {
    //         cursor.classList.remove('hover');
    //     });
    // })


    // //Preloder
    // jQuery(window).on('load', function () {
    //     $(".preloader_area_wrap").delay(1600).fadeOut("slow");
    // });

    //Active menu
    const currentLocation = location.href;
    const menuItem = document.querySelectorAll('ul li a');
    const menuLength = menuItem.length;
    for (let i = 0; i < menuLength; i++) {
        if (menuItem[i].href === currentLocation) {
            menuItem[i].className = "active";
        }
    }

    //sticky menu
    $(window).on('scroll', function () {

        if ($(this).scrollTop() > 100) {
            $('.position_top').addClass('sticky');
        } else {
            $('.position_top').removeClass('sticky');
        }
    });


    // Scroll Top btn
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 800) {
            $('.scroll-top').fadeIn().addClass('opacity');
        } else {
            $('.scroll-top').fadeOut();
        }
    });
    $('.scroll-top').on('click', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return false;
    });


    //Mobile menu
    $('.cross-btn').on('click', function (event) {
        $(this).toggleClass('h-active');
        $('.main-nav').toggleClass('slidenav');
    });

    $(".main-nav .bi").on('click', function (event) {
        var $fl = $(this);
        $(this).parent().siblings().find('.sub-menu').slideUp();
        $(this).parent().siblings().find('.bi').addClass('bi-chevron-down');
        if ($fl.hasClass('bi-chevron-down')) {
            $fl.removeClass('bi-chevron-down').addClass('bi-chevron-up');
        } else {
            $fl.removeClass('bi-chevron-up').addClass('bi-chevron-down');
        }
        $fl.next(".sub-menu").slideToggle();
    });


    //Counter up
    $('.odometer').counterUp({
        delay: 10,
        time: 1000
    });


    //Isotope with image load
    $('ul.project-filter-tab li').on('click', function () {

        $("ul.project-filter-tab li").removeClass("active");
        $(this).addClass("active");

        var selector = $(this).attr('data-filter');
        $(".project-items-wrapper").isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false,
            }
        });
        return false;
    });
    // init Masonry
    var $grid = $('.portfolio-masonary-wrapper').masonry({
        itemSelector: '.portfolio-masonary',
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress(function () {
        $grid.masonry();
    });




    //Isotope with image load
    $('ul.project-item-menu li').on('click', function () {

        $("ul.project-item-menu li").removeClass("active");
        $(this).addClass("active");

        var selector = $(this).attr('data-filter');
        $(".project-grid").isotope({
            filter: selector,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false,
            }
        });
        return false;
    });
    // init Masonry
    var $grid2 = $('.project-grid').masonry({
        itemSelector: '.project-grid-item',
    });
    // layout Masonry after each image loads
    $grid2.imagesLoaded().progress(function () {
        $grid2.masonry();
    });


    //Circle progress bar
    $(".progress-bar-circle").loading();


    //Bar filler skill
    $('#bar1').barfiller();
    $('#bar2').barfiller();
    $('#bar3').barfiller();
    $('#bar4').barfiller();

    //Video popup
    $('.popup-video').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,

        fixedContentPos: false
    });
    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }

    });

    //Home slider
    var swiper = new Swiper(".hero-slider", {
        slidesPerView: 1,
        speed: 1500,
        spaceBetween: 0,
        loop: true,
        effect: 'fade',
        centeredSlides: true,
        roundLengths: true,
        fadeEffect: {
            crossFade: true
        },
        autoplay: {
            delay: 4000
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });


    //Home slider 3
    var swiper = new Swiper('.hero-slider-3', {
        spaceBetween: 30,
        centeredSlides: true,
        effect: 'fade',
        autoplay: {
            delay: 8500,
        },
        navigation: {
            nextEl: '.swiper-button-next-c',
            prevEl: '.swiper-button-prev-c',
        },
    });


    // Portfolio slider
    var swiper = new Swiper(".portfolio-slider", {
        slidesPerView: 5,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 5000,
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 30
            },

            // when window width is >= 640px
            768: {
                slidesPerView: 3,
                spaceBetween: 40
            },
            // when window width is >= 992px
            992: {
                slidesPerView: 4,
                spaceBetween: 40
            },
            // when window width is >= 1400px
            1400: {
                slidesPerView: 5,
                spaceBetween: 40
            },
        }
    });

    // Portfolio slider
    var swiper = new Swiper(".releted-project-slider", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 5000,
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 30
            },

            // when window width is >= 640px
            768: {
                slidesPerView: 3,
                spaceBetween: 40
            }
        }
    });

    //testimonial slider
    var swiper = new Swiper(".testimonial-slider", {
        slidesPerView: 1,
        loop: true,
        speed: 2000,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: ".swiper-pagination",
            type: "fraction",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    //testimonial slider two
    var swiper = new Swiper(".testimonial2-slider", {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        speed: 2000,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 0,
            },

            // when window width is >= 640px
            768: {
                slidesPerView: 2,
            },
            // when window width is >= 992px
            992: {
                slidesPerView: 3,
            },
        }
    });


    //Work-process slider
    var swiper = new Swiper(".work-process", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });


    // Contact Form

    // Get the form.
    var form = $('#contact-form');

    // Get the messages div.
    var formMessages = $('.form-message');

    // Set up an event listener for the contact form.
    $(form).on('submit', function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        // Serialize the form data.
        var formData = $(form).serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })
            .done(function (response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('error');
                $(formMessages).addClass('success');

                // Set the message text.
                $(formMessages).text(response);

                // Clear the form.
                $('#contact-form input,#contact-form textarea').val('');
            })
            .fail(function (data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('success');
                $(formMessages).addClass('error');

                // Set the message text.
                if (data.responseText !== '') {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text('Oops! An error occured. Message could not be sent.');
                }
            });
    });

}(jQuery));


(function ($) {
    // Form validation using jQuery
    $('.needs-validation').each(function () {
        let $form = $(this);

        $form.on('submit', function (e) {
            if (this.checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            }
            $form.addClass('was-validated');
        });

        // Real-time validation
        $form.find('input, select, textarea').on('input', function () {
            let $field = $(this);
            if (this.checkValidity()) {
                $field.addClass('is-valid').removeClass('is-invalid');
            } else {
                $field.addClass('is-invalid').removeClass('is-valid');
            }
        });
    });

    // Axios AJAX submit
    $(document).on('submit', 'form[data-axios="true"]', function (e) {
        e.preventDefault();

        let $form = $(this);
        let url = $form.data('action');
        let method = $form.data('method') || 'POST';
        let formData = new FormData(this);

        // Disable button while processing
        let $btn = $form.find('button[type="submit"]');
        $btn.prop('disabled', true).text('Processing...');

        axios({
            method: method,
            url: url,
            data: formData,
            headers: { 'Content-Type': 'multipart/form-data' }
        })
            .then(response => {
                if (response.data.redirect) {
                    window.location.href = response.data.redirect;
                } else {
                    alert(response.data.message);
                    console.log(response.data);
                }
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    let errors = error.response.data.errors;

                    // Show errors below each input
                    $.each(errors, function (field, messages) {
                        let $input = $form.find(`[name="${field}"]`);
                        $input.addClass('is-invalid');
                        let $errorDiv = $input.siblings('.invalid-feedback');
                        if ($errorDiv.length) {
                            $errorDiv.text(messages[0]).show();
                        }
                    });
                }
            })
            .finally(() => {
                $btn.prop('disabled', false).text('Success ✔');
            });
    });

})(jQuery);

function showToast(message, type = 'success') {
    const toast = $(`
                <div class="custom-toast">${message}</div>
            `).css({
        position: 'fixed',
        bottom: '20px',
        right: '20px',
        background: type === 'success' ? '#28a745' : '#dc3545',
        color: '#fff',
        padding: '10px 20px',
        borderRadius: '6px',
        boxShadow: '0 2px 6px rgba(0,0,0,0.3)',
        zIndex: '9999'
    }).appendTo('body');

    setTimeout(() => toast.fadeOut(400, () => toast.remove()), 2500);
}


        
        $(document).ready(function() {
            let deleteUrl = '';
            let deleteId = '';
            const modalEl = $('#deleteModal');
            const planNameEl = $('#planName');
            const confirmDeleteBtn = $('#confirmDelete');

            // Open Delete Modal
            $('.itemDelete').on('click', function() {
                console.log('Delete button clicked');
                
                deleteUrl = $(this).data('url');
                deleteId = $(this).data('item_id');
                const planName = $(this).data('name') || 'this plan';

                planNameEl.text(planName);
                modalEl.modal('show');
            });

            // Confirm Delete
            confirmDeleteBtn.on('click', function() {
                
                axios.delete(deleteUrl, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (response.status === 201 || response.data.success) {
                            // Remove the card from the UI
                            $(`button[data-item_id="${deleteId}"]`).closest('.col-lg-4').remove();

                            showToast('Plan deleted successfully!', 'success');
                            modalEl.modal('hide');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                        } else {
                            showToast('Failed to delete the plan.', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        showToast('Something went wrong while deleting.', 'danger');
                    });
            });

            // Toast notification helper
            function showToast(message, type = 'success') {
                const toast = $(`
                <div class="custom-toast">${message}</div>
            `).css({
                    position: 'fixed',
                    bottom: '20px',
                    right: '20px',
                    background: type === 'success' ? '#28a745' : '#dc3545',
                    color: '#fff',
                    padding: '10px 20px',
                    borderRadius: '6px',
                    boxShadow: '0 2px 6px rgba(0,0,0,0.3)',
                    zIndex: '9999'
                }).appendTo('body');

                setTimeout(() => toast.fadeOut(400, () => toast.remove()), 2500);
            }
        });





        