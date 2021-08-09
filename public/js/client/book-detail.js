// const { comment } = require("postcss");


let readMore = document.querySelector('#js-read-more');
let desc = document.querySelector('.book-description__text');
if (desc.offsetHeight < 240) {
    desc.parentNode.style.height = "auto";
    readMore.style.display = "none";
}

readMore.addEventListener('click', () => {
    let x = readMore.parentElement.querySelector('.book-description__wrapper')
    x.classList.toggle("show-more");
    (x.classList.contains('show-more')) ? readMore.innerHTML = "Ẩn bớt " : readMore.innerHTML = "Xem thêm ";
})


// let replyParentElement = document.querySelectorAll('.js-comment-reply');
// let btnCancelElement = document.querySelectorAll('.button-cancel');
// let commentWrapperElement = document.querySelectorAll('.comment-box__wrapper');
// let replyChildElement = document.querySelectorAll('.js-comment-reply-child');
// replyParentElement.forEach((item) => {
//     item.addEventListener('click', () => {
//         item.closest('.js-comment-body').querySelector('.comment-box__wrapper').classList.remove(
//             'comment-box__hidden');
//         item.closest('.js-comment-body').querySelector('input[name="body"]').focus();
//     })
// })
// // turn off comment box
// btnCancelElement.forEach((btn, index) => {
//     btn.addEventListener('click', () => {
//         commentWrapperElement[index].classList.add('comment-box__hidden');
//         commentWrapperElement[index].querySelector('form').reset();

//     })
// })
// // Chọn trả lời thằng con 
// replyChildElement.forEach((item, index) => {
//     item.addEventListener('click', () => {
//         const a = item.closest('.js-comment-body').querySelector('.comment-box__wrapper');
//         a.classList.remove('comment-box__hidden');
//         a.querySelector('input[name="body"]').focus();
//         // console.log(item.parentElement.parentElement.parentElement.parentElement.parentElement.querySelector('.comment-box__wrapper').classList.remove('comment-box__hidden'))
//     })
// })


/**
 * Làm phân trang comment
 * 
 */

var url = window.location.pathname;
var id = url.substring(url.lastIndexOf('/') + 1);


let jsBookUserCommentEl = document.querySelector('#js-book-user-comment');


let jsUserAvatar = document.querySelector('#js-user-avatar');
moment.locale('vi');


loadMore()


const replyParent = (replyParentElement) => {
    replyParentElement.forEach((item) => {
        item.addEventListener('click', () => {
            item.closest('.js-comment-body').querySelector('.comment-box__wrapper').classList.remove(
                'comment-box__hidden');
            item.closest('.js-comment-body').querySelector('input[name="body"]').focus();
        })
    })
}

// Chọn trả lời thằng con 
const replyChild = (replyChildElement) => {

    replyChildElement.forEach((item, index) => {
        item.addEventListener('click', () => {
            console.log(item, index);
            const a = item.closest('.js-comment-body').querySelector('.comment-box__wrapper');
            a.classList.remove('comment-box__hidden');
            a.querySelector('input[name="body"]').focus();
            // console.log(item.parentElement.parentElement.parentElement.parentElement.parentElement.querySelector('.comment-box__wrapper').classList.remove('comment-box__hidden'))
        })
    })
}

// turn off comment box
const cancelReply = (btnCancelElement) => {

    btnCancelElement.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            $('.comment-box__wrapper')[index].classList.add('comment-box__hidden');
            body[index].value = "";

        })
    })
}




// Gửi dữ liệu đăng nhập bằng ajax




function loadMore(bookId = "") {
    $.ajax({
        url: "/api/comment",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            book_id: bookId
        },
        success: function (data) {
            console.log(data)
            if (data) {
                let lastId;
                let arrId = [];
                const comments = [...data[0]];
                const commentsChild = [...data[1]];
                console.log(commentsChild)

                // Hiển thị dữ liệu
                const result = comments.map(comment => {
                    lastId = comment.id;

                    return `<div class="book-user-comment">
                                <div class="comment-box__image">
                                    <img src="${comment.user.avatar}" alt="">
                                </div>
                                <div class="book-user-comment__body js-comment-body" data-parent_id = "${comment.id}">
                                    <div class="book-user-comment__heading">
                                        <div class="book-user-comment__name">${comment.user.name}</div>
                                        <div class="book-user-comment__content">${comment.body}</div>
                                    </div>
                                    <div class="book-user-comment__footer">
                                        <div class="book-user-comment__link"><a href="javascript:void(0);" class="js-comment-reply"
                                                id="js-comment-reply-${comment.id}">Trả lời</a></div>
                                        <div class="book-user-comment__date">
                                            ${moment(comment.created_at).fromNow()}
                                        </div>
                                        
                                    </div>
                                    <div class="book-user-comment-wrapper js-comment-child-wrapper" data-parent_id = "${comment.id}">
                                    ${commentsChild.map((commentChild, index) => {
                        if (commentChild.parent_id == comment.id) {

                            return `<div class="book-user-comment js-comment-child " data-comment_id ="${commentChild.id}">
                                                        <div class="comment-box__image">
                                                            <img src="${commentChild.user.avatar}" alt="">
                                                        </div>
                                                        <div class="book-user-comment__body">
                                                            <div class="book-user-comment__heading">
                                                                <div class="book-user-comment__name" >${commentChild.user.name} </div>
                                                                <div class="book-user-comment__content ">${commentChild.body}</div>
                                                            </div>
                                                            <div class="book-user-comment__footer">
                                                                <div class="book-user-comment__link"><a href="javascript:void(0);"
                                                                        class="js-comment-reply-child">Trả lời</a></div>
                                                                <div class="book-user-comment__date">
                                                                    ${moment(commentChild.created_at).fromNow()}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`
                        }
                    }).join("")}
                </div>
                                    <div class="comment-box__wrapper comment-box__hidden">
                                        <div class="comment-box__image">
                                            <img src="${jsUserAvatar.src}" alt="">
                                        </div>
                                        <div class="comment-box__content">
                                                <div class="comment__input">
                                                    <input type="text" name="body" placeholder="Viết bình luận..."
                                                        id="js-reply-input-${comment.id}">
                                                    <input type=hidden name="book_id" value="${id}" />
                                                    <input type=hidden name="parent_id" value="${comment.id}" />
                                                </div>
                                                <div class="comment__btn">
                                                    <button type="button"  class="button button__background-lg button-comment js-button-comment">
                                                    <span class="spinner-grow spinner-grow-sm hidden" role="status" aria-hidden="true"></span>
                                                    Bình luận</button>
                                                    <button type="button" class="button button__background-lg button-cancel">Hủy</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                }).join("");
                // Hiển thị nút xem thêm
                $('#js_load_more_btn').remove();
                $('#js-book-user-comment').append(result);
                if (comments.length >= 3) {
                    $('#js-book-user-comment').append(`<button type="button" name="abc" id="js_load_more_btn" data-id="${lastId}" class="button btn-load-more">Xem thêm bình luận</button>`);
                }

                // let jsCommentBody = document.querySelectorAll('.js-comment-body');
                // jsCommentBody.forEach((item, index) => {
                //     const loadMoreButtonChild = $(`<button type="button" class="button btn-load-more js-btn-load-more-child">Xem thêm bình luận</button>`);
                //     let hasX = item.querySelector('.js-btn-load-more-child')
                //     if (hasX) {

                //         hasX.remove()
                //     }
                //     console.log(item,index)
                //     item.append(loadMoreButtonChild[0]);
                //     let x = item.querySelector('.js-btn-load-more-child')



                //     x.addEventListener('click', () => {
                //         let lasttiem;
                //         const jsCommentChild = item.querySelectorAll('.js-comment-child');
                //         const abcccc = item.getAttribute("data-parent_id");
                //         console.log(abcccc)
                //         jsCommentChild.forEach(item => {
                //             lasttiem = item.getAttribute("data-comment_id")
                //         })
                //         console.log(lasttiem)
                //         console.log(item)
                //         loadMoreChild(lasttiem, abcccc, item)

                //     })
                // })
                let jsCommentBody = document.querySelectorAll('.js-comment-child-wrapper');
                if (commentsChild.length > 0) {
                    jsCommentBody.forEach((item, index) => {
                        parentIde = item.getAttribute("data-parent_id")
                        console.log(parentIde)

                        const loadMoreButtonChild = $(`<button type="button" class="button btn-load-more js-btn-load-more-child">Xem thêm bình luận</button>`);
                        let hasX = item.querySelector('.js-btn-load-more-child')
                        if (hasX) {

                            hasX.remove()
                        }
                        

                        let count = 0;
                        commentsChild.forEach(child => {
                            if (child.parent_id == parentIde) {
                                console.log(child)
                                count++;
                            }
                        })
                        console.log(count)
                        if(count  == 3){
                            item.append(loadMoreButtonChild[0]);
                            let x = item.querySelector('.js-btn-load-more-child')
                            x.addEventListener('click', () => {
                                let lasttiem;
                                const jsCommentChild = item.querySelectorAll('.js-comment-child');
                                const abcccc = item.getAttribute("data-parent_id");
                                console.log(abcccc)
                                jsCommentChild.forEach(commentChildItem => {
                                    lasttiem = commentChildItem.getAttribute("data-comment_id")
                                })
                                console.log(lasttiem)
                                loadMoreChild(lasttiem, abcccc, item)
    
                            })
                        }


                    })
                }

                // Xử lý khi bấm vào reply
                let loading = document.querySelectorAll('.spinner-grow'); // Loadding spinner
                let btnCancelElement = document.querySelectorAll('.button-cancel'); // Nút hủy bình luận
                let replyChildElement = document.querySelectorAll('.js-comment-reply-child'); // Nút trả lời của bình luận con
                let replyParentElement = document.querySelectorAll('.js-comment-reply'); // Nút trả lời của bình luận cha
                replyParent(replyParentElement);
                replyChild(replyChildElement);
                cancelReply(btnCancelElement);

                //Xử lý khi gửi dữ liệu
                let button = document.querySelectorAll('.js-button-comment');
                let body = document.querySelectorAll('input[name="body"]');
                let bookId = document.querySelectorAll('input[name="book_id"]');
                let parentId = document.querySelectorAll('input[name="parent_id"]');
                button.forEach((btn, index) => {
                    btn.addEventListener('click', () => {
                        if (body[index].value.length < 1) { return }
                        $(document)
                            .ajaxStart(function () {
                                loading[index].classList.remove('hidden');
                                btn.setAttribute('disabled', "");
                            })
                            .ajaxStop(function () {
                                loading[index].classList.add('hidden');
                                btn.removeAttribute('disabled')
                                location.reload();
                            });
                        $.ajax({
                            url: "/comment-store",
                            method: "Post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                body: body[index].value,
                                book_id: bookId[index].value,
                                parent_id: parentId[index].value,
                            },
                            success: function (data) {
                                if (data.error) return;
                                //fire off other ajax calls

                            },
                            complete: function (response, status) {
                                console.log(response.statusCode);
                                // do something
                            }
                        })
                    })
                })
            }
        }

    })
}

function loadMoreChild(commentId, parrentId, item) {
    $.ajax({
        url: '/api/comment-child',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            commentId: commentId,
            parrentId: parrentId
        },
        success: function (data) {
            console.log(data)
            const commentsChild = [...data];
            const result = commentsChild.map(commentChild => {
                return `<div class="book-user-comment js-comment-child " data-comment_id ="${commentChild.id}">
                            <div class="comment-box__image">
                                <img src="${commentChild.user.avatar}" alt="">
                            </div>
                            <div class="book-user-comment__body">
                                <div class="book-user-comment__heading">
                                    <div class="book-user-comment__name" >${commentChild.user.name} </div>
                                    <div class="book-user-comment__content ">${commentChild.body}</div>
                                </div>
                                <div class="book-user-comment__footer">
                                    <div class="book-user-comment__link"><a href="javascript:void(0);"
                                            class="js-comment-reply-child">Trả lời</a></div>
                                    <div class="book-user-comment__date">
                                        ${moment(commentChild.created_at).fromNow()}
                                    </div>
                                </div>
                            </div>
                        </div>

                        `

            }).join("")
            $(item).append(result);

            const btnnnn = item.querySelector('.js-btn-load-more-child');
            btnnnn.remove()
            if (commentsChild.length == 3) {
                const loadMoreButtonChild = $(`<button type="button" class="button btn-load-more js-btn-load-more-child">Xem thêm bình luận</button>`);
                item.append(loadMoreButtonChild[0])
            }

            let x = item.querySelector('.js-btn-load-more-child')

            console.log(x)
            if (x != null) {
                x.addEventListener('click', () => {
                    let lasttiem;
                    const jsCommentChild = item.querySelectorAll('.js-comment-child');
                    const abcccc = item.getAttribute("data-parent_id");
                    console.log(abcccc)
                    jsCommentChild.forEach(item => {
                        lasttiem = item.getAttribute("data-comment_id")
                    })
                    console.log(lasttiem)
                    loadMoreChild(lasttiem, abcccc, item)

                })
            }

            
            let loading = document.querySelectorAll('.spinner-grow'); // Loadding spinner
            let btnCancelElement = document.querySelectorAll('.button-cancel'); // Nút hủy bình luận
            let replyChildElement = document.querySelectorAll('.js-comment-reply-child'); // Nút trả lời của bình luận con
            let replyParentElement = document.querySelectorAll('.js-comment-reply'); // Nút trả lời của bình luận cha
            replyParent(replyParentElement);
            replyChild(replyChildElement);
            cancelReply(btnCancelElement);

            // item.remove()
            // let jsCommentBody = document.querySelectorAll('.js-comment-body'); // Nút trả lời của bình luận con
            // console.log(result)
            // item.append(result);
            // jsCommentBody.forEach((item, index) => {
            //     const loadMoreButtonChild = $(`<button type="button" class="button btn-load-more js-btn-load-more-child">Xem thêm bình luận</button>`);
            //     item.append(loadMoreButtonChild[0]);
            //     let x = item.querySelector('.js-btn-load-more-child')
            //     const jsCommentChild = item.querySelectorAll('.js-comment-child');



            //     x.addEventListener('click', () => {
            //         let lasttiem;
            //         const abcccc = item.getAttribute("data-parent_id");
            //         console.log(abcccc)
            //         console.log(jsCommentChild[2], index);
            //         jsCommentChild.forEach(item => {
            //             lasttiem = item.getAttribute("data-comment_id")
            //         })
            //         console.log(lasttiem)
            //         loadMoreChild(lasttiem, abcccc)
            //         console.log('Click xem thêm ' + newArr[index])
            //     })
            // })
        }
    })
}
$(document).on('click', '#js_load_more_btn', (e) => {
    const bookId = $(e.target).attr("data-id");
    let jsCommentBody = document.querySelectorAll('.js-comment-body');
    // console.log(jsCommentBody)
    // jsCommentBody.forEach((item, index) => {
    //     let x = item.querySelector('.js-btn-load-more-child')
    //     x.remove()
    // })

    loadMore(bookId)

})

// window.onload = (function () {
//     let jsCommentBody = document.querySelectorAll('.js-btn-load-more-child');
//     console.log(jsCommentBody)

// });

    // @foreach (comments as commentChild)
    //                     @if (commentChild.parent_id != null && commentChild.parent_id == comment.id && comment.status==1)

    //                         <div class="book-user-comment">
    //                             <div class="comment-box__image">
    //                                 <img src="${ commentChild.user.avatar }" alt="">
    //                             </div>
    //                             <div class="book-user-comment__body">
    //                                 <div class="book-user-comment__heading">
    //                                     <div class="book-user-comment__name">${ commentChild.user.name }</div>
    //                                     <div class="book-user-comment__content">${ commentChild.body }</div>
    //                                 </div>
    //                                 <div class="book-user-comment__footer">
    //                                     <div class="book-user-comment__link"><a href="javascript:void(0);"
    //                                             class="js-comment-reply-child">Trả lời</a></div>
    //                                     <div class="book-user-comment__date">
    //                                         ${ commentChild.created_at }</div>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     @endif
    //                 @endforeach
    //                 <div class="comment-box__wrapper comment-box__hidden">
    //                     <div class="comment-box__image">
    //                         <img src="${ Auth::user().avatar }" alt="">
    //                     </div>
    //                     <div class="comment-box__content">
    //                         <form action="${ route('comments.store') }" method="post">
    //                             @csrf
    //                             <div class="comment__input">
    //                                 <input type="text" name="body" placeholder="Viết bình luận..."
    //                                     id="js-reply-input-${ comment.id }">
    //                                 <input type=hidden name="book_id" value="${ $book_id }" />
    //                                 <input type=hidden name="parent_id" value="${ comment.id }" />
    //                             </div>
    //                             <div class="comment__btn">
    //                                 <button type="submit" class="button button__background-lg button-comment">Bình
    //                                     luận</button>
    //                                 <button type="button" class="button button__background-lg button-cancel">Hủy</button>
    //                             </div>
    //                         </form>
    //                     </div>

    //                 </div>








