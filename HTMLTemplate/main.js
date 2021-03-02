$(document).ready(function(){
    //navbar
    let nav_offset_top = $('.landing-photo').height() - 550;

    function navBarFixed()
    {
        if($('.landing-photo').length)
        {
            $(window).scroll(function(){
                let scroll = $(window).scrollTop();
                if(scroll >= nav_offset_top)
                {
                    $('.hd nav').addClass('navbar_fixed');
                    $('.hd nav a').addClass('color-black');
                }
                else
                {
                    $('.hd nav').removeClass('navbar_fixed');
                    $('.hd nav a').removeClass('color-black');
                }
            })
        }
    }
    navBarFixed();

    //counter
    $(function(){
        $('#myFlipper').flipper('init');
    });

    //stellar
    $.stellar();

    //AOS Library
    AOS.init();

    //tilt.js
    VanillaTilt.init(document.querySelector(".gif-container"), {
		max: 10,
        speed: 400,
	});
	
	//It also supports NodeList
    VanillaTilt.init(document.querySelectorAll(".gif-container"));

    //Swiper Carousel------------
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        loopFillGroupWithBlank: true,
        coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 470,
            modifier: 1,
            slideShadows : true,
        },
        autoplay: {
            delay: 1500,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });

    //depended select
    var $select1 = $( '#select1' ),
		$select2 = $( '#select2' ),
    $options = $select2.find( 'option' );
    
    $select1.on( 'change', function() {
        $select2.html( $options.filter( '[value="' + this.value + '"]' ) );
    } ).trigger( 'change' );

    var statusLogin = true;
    var loginPass = $('.login input[type="password"]');
    $('.login #eye i').click(function(){
        if(statusLogin)
        {
            $('.login #eye i').removeClass('fa');
            $('.login #eye i').removeClass('fa-eye');
            $('.login #eye i').addClass('fas');
            $('.login #eye i').addClass('fa-eye-slash');
            loginPass.attr("type", "text");
            statusLogin = false;
        }
        else
        {
            $('.login #eye i').removeClass('fas');
            $('.login #eye i').removeClass('fa-eye-slash');
            $('.login #eye i').addClass('fa');
            $('.login #eye i').addClass('fa-eye');
            loginPass.attr("type", "password");
            statusLogin = true;
        }
    });

    var statusRegi = true;
    var regiPass = $('.registerModal input[type="password"]');
    $('.registerModal #eye i').click(function(){
        if(statusRegi)
        {
            $('.registerModal #eye i').removeClass('fa');
            $('.registerModal #eye i').removeClass('fa-eye');
            $('.registerModal #eye i').addClass('fas');
            $('.registerModal #eye i').addClass('fa-eye-slash');
            regiPass.attr("type", "text");
            statusRegi = false;
        }
        else
        {
            $('.registerModal #eye i').removeClass('fas');
            $('.registerModal #eye i').removeClass('fa-eye-slash');
            $('.registerModal #eye i').addClass('fa');
            $('.registerModal #eye i').addClass('fa-eye');
            regiPass.attr("type", "password");
            statusRegi = true;
        }
    });

    //Datatable
    $('#leaderboardtb').DataTable({
        "ordering": false,
        responsive: true,
        language: {
            "search": "Search: ",
            "searchPlaceholder": "Search Data",
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "lengthMenu": [[10, 20, 50], [10, 20, 50]]
    });

    var $button = $.backToTop({
        // background color
        backgroundColor: '#007bff',

        // text color
        color: '#FFFFFF',

        // container element
        container: this._body, 

        // 'nonn', 'spin', 'fade', 'zoom', or 'spin-inverse'
        effect: 'spin',

        // enable the back to top button
        enabled: true, 

        // width/height of the back to top button
        height: 50,  
        width: 50,

        // icon
        icon: 'fas fa-chevron-up',

        // margins 
        marginX: 10,
        marginY: 10,  

        // bottom/top left/right
        position: 'bottom right',           

        // trigger position
        pxToTrigger: 200,

        // or 'fawesome'
        theme: 'fawesome',
    });

    $('[data-toggle="tooltip"]').tooltip();  

    $('#hintwarning').on("click", function(){
        swal({
            title: "Are you sure?",
            text: "You will lose your 1 credit from ramaining credits",
            icon: "warning",
            buttons: true
          })
          .then((willDelete) => {
            if (willDelete) {
              swal({
                title: "Hint",
                text: "Your hint is......",
                icon: "success",
              });
            }
          });
    });
    
    //floating
    $('#myLink').dockedLink({
        position: 'left',
        pixelsFromTop: 500
        })
        .css({
            border: '3px solid #3498DB',
            borderLeft: 'none'
    });
});

window.addEventListener("load", function(){
    const loader = document.querySelector(".preloader"); 
    loader.className += " hidden";
});