/*!
* Start Bootstrap - Clean Blog v6.0.8 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/
window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    const headerHeight = mainNav.clientHeight;
    window.addEventListener('scroll', function() {
        const currentTop = document.body.getBoundingClientRect().top * -1;
        if ( currentTop < scrollPos) {
            // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible');
            } else {
                console.log(123);
                mainNav.classList.remove('is-visible', 'is-fixed');
            }
        } else {
            // Scrolling Down
            mainNav.classList.remove(['is-visible']);
            if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-fixed');
            }
        }
        scrollPos = currentTop;
    });

  
    let inputComment = document.getElementById('inputComment');
    let postId= inputComment.getAttribute('data-id');
    let btnComment = document.getElementById('btnComment');
    let containerComment = document.getElementsByClassName('containerComment');
    
    
    
    btnComment.addEventListener('click', getComment)
    function getComment(){
        
        // fetch retourn une promesse
        fetch('/comment/create/'+ postId)
        .then(function(Response){
            return Response.json();
        }).then(function (data){
            // console.log(data)
            containerComment.innerHTML='';
            for(comment of data){
                containerComment.innerHTML+= '<div class="itemComment"><p class="text">'+comment.contenue+'</p><span class="date">'+comment.createdAt+'</span></div>';
            }
            
        })
        

    }



    
})
