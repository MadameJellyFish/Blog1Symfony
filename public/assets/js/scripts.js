/*!
* Start Bootstrap - Clean Blog v6.0.8 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/
window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    const headerHeight = mainNav.clientHeight;
    window.addEventListener('scroll', function () {
        const currentTop = document.body.getBoundingClientRect().top * -1;
        if (currentTop < scrollPos) {
            // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible');
            } else {
                // console.log(123);
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
    let postId = inputComment.getAttribute('data-id');
    let btnComment = document.getElementById('btnComment');
    let btnLike = document.getElementById('btnLike');
    let nbLikes = document.getElementById('nbLikes');
    
    
    btnComment.addEventListener('click', getComment)
    function getComment() {
        
        // fetch retourn une promesse
        // method tout ça pour recuperer les argements aves les parametres facultatives
        fetch('/comment/create/' + postId, {
            method: "POST",
            headers: { "content-type": 'Applications/json' },
            body: JSON.stringify({
                'textareaComment': inputComment.value
            })
        })
        .then(function (response) {
            return response.json();
        }).then(function (data) {
                let containerComment = document.querySelector('.containerComment');
                // console.log(containerComment);
                containerComment.innerHTML = '';
                for (comment of data) {
                    containerComment.innerHTML += '<div class="itemComment"><p class="text">'
                        + comment.contenue + '</p><span class="date"><span class="published"> Published on </span>'
                        + comment.createdAt + '</span></div>'; 
                }
            })
    }

    btnLike.addEventListener('click', getLike)
    function getLike(){
        fetch('/like/create/'+ postId)
        .then(function (response) {
            return response.json();
        }).then(function (data) {
            console.log(data);
            nbLikes.innerHTML=data.nbLikes;
            if(data.nbLikes < 1){
                console.log(nbLikes);
                nbLikes.style.display="none";
               }else{
                nbLikes.style.display="inline-block";
               }
           
            // let qualification = document.querySelector('.qualification');
        })
    }



})
