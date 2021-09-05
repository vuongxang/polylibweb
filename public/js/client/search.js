$(function ($) {
    let jsFilterItem = document.getElementsByClassName('js-filter-item');
    let jsFilterInput = document.getElementsByClassName('filter-item__input');

    let cates = []


    const prev = document.querySelectorAll('.slide-nav__prev');
    const next = document.querySelectorAll('.slide-nav__next');

    const track = document.querySelectorAll('.author-books__list');

    // let carouselWidth = document.querySelector('.search-author__container').offsetWidth;
    let carouselWidth = 855;

    // window.addEventListener('resize', () => {
    //     carouselWidth = document.querySelector('.search-author__container').offsetWidth;
    // })
    // console.log(carouselWidth)
    const newTrack = [...track]
    let index = 0;
    const indexArray = newTrack.map(function () {
        return 0

    })
    track.forEach((item, ind) => {
        let num = item.querySelectorAll('.book-card');
        if (num.length < 3) {
            next[ind].classList.add('hide')
        }
    })
    next.forEach((item, i) => {
        item.addEventListener('click', () => {
            indexArray[i]++;
            prev[i].classList.add('show');
            track[i].style.transform = `translateX(-${indexArray[i] * carouselWidth}px)`;

            if (track[i].offsetWidth - (indexArray[i] * carouselWidth) < carouselWidth) {
                item.classList.add('hide');
            }
        })
    })


    prev.forEach((item, i) => {
        item.addEventListener('click', () => {
            indexArray[i]--;
            next[i].classList.remove('hide');
            if (indexArray[i] === 0) {
                item.classList.remove('show');
            }
            track[i].style.transform = `translateX(-${indexArray[i] * carouselWidth}px)`;
        })
    })



    function GetURLParameter(sParam) {
        var sPageURL = window.location.search.substring(1);


        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }
    }


    let keyword = $('input[name= "keyword"]').val();

    // console.log(keyword)
    // const keyword = decodeURI(GetURLParameter('keyword'))
    for (const item of jsFilterItem) {

        item.addEventListener("click", () => {

            if (item.querySelector('input').checked == false) {
                item.querySelector('input').checked = true;
                cates.push(parseInt(item.querySelector('input').value))
            } else {
                if (item.querySelector('input').checked == true) {
                    item.querySelector('input').checked = false;
                    cates = cates.filter(cate => {
                        return cate != parseInt(item.querySelector('input').value)
                    })

                }
            }
            // if(Array.isArray(cates) && cates.length > 0){
            $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: '/filter',
                method: "get",
                data:
                // jQuery.param({ cates: cates, keyword : keyword})  ,
                {
                    cates: cates,
                    keyword: keyword
                },

                dataType: 'json',
                success: function (res) {
                    console.log(res)
                    const books = [...res[0]];

                    const key = [res[1]];
                    const auth = res[2];
                    if (Array.isArray(books) && books.length > 0) {
                        const result = books.map((book) => {
                            let avg = 0
                            if (book.rates.length > 0) {
                                const sum = book.rates?.reduce((a, b) => a.rating + b.rating);
                                avg = (sum / book.rates?.length) || 0;
                            }
                            
                            return `<div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="/book-detail/${book.slug}">
                                            <img src="${book.image}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="/book-detail/${book.slug}">
                                            <h3> ${book.title} </h3>
                                        </a>
                                    </div>
                                    <div class="book-card__author">
                                    ${book.authors.map(item => { return ` ${item.name}` })}
                                    </div>
                                    <div class="book-card__star">
                                    ${(function rates() {
                                    let a = ''
                                    for ($i = 1; $i <= 5; $i++) {
                                        if (avg > $i) {
                                            a += '<i class="fas fa-star"></i> '
                                        } else {
                                            a += '<i class="far fa-star"></i> '
                                        }
                                    }
                                    return a;
                                })()}
                                    </div>
                                    <div class="book-card__btn">
                                    
                                    
                                    ${(function rates() {
                                    let link ;
                                    if (book.orders.length == 0) {
                                        link = `<a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                                <a href="/review/${book.slug}" class="review-btn">Xem trước</a>`
                                    }
                                    book.orders.map(order => {
                                        // console.log(parseInt(order.id_user), auth.id)
                                        if (parseInt(order.id_user) == auth.id) {
                                            if (order.status == 'Đang mượn') {
                                                link = `<a href="/read/${book.slug}" class="review-btn">Đọc sách</a>`

                                            }
                                            else {
                                                link = `<a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                                    <a href="/review/${book.slug}" class="review-btn">Xem trước</a>`
                                            }
                                        }


                                    }).join('')
                                    return link;
                                })()}
                                
                                    </div>
                                </div>
                                `
                        }).join("");
                        $('#book-qty').empty();
                        $('#book-qty').append((books.length));
                        $('#js-search-text').html(`Tìm thấy <span id="book-qty">${books.length}</span> kết quả cho <span class="search-text-detail">"${key}"</span>`);
                        $('#js-book-card-collection').empty();
                        $('#js-book-card-collection').html(result);
                    }
                    if (Array.isArray(books) && books.length == 0) {
                        $('#js-book-card-collection').empty();
                        $('#js-search-text').html('Không tìm thấy kết quả nào');
                    }

                },
                error: function (xhr, status, error) {
                    // console.log("Error!" + xhr.error);
                },

            })
            // }
        })
    }

    $('#filter-form :checkbox').change(function () {
        if (this.checked) {
            cates.push(parseInt(this.value))
        } else {
            cates = cates.filter(cate => {
                return cate != parseInt(this.value)
            })
        }
        $.ajax({

            url: '/filter',
            method: "get",
            data: {
                cates: cates,
                keyword: keyword
            },

            dataType: 'json',
            success: function (res) {
                const books = [...res[0]];
                const key = [res[1]];
                if (Array.isArray(books) && books.length > 0) {
                    const result = books.map((book) => {
                        const sum = book.rates?.reduce((a, b) => a.rating + b.rating);
                        const avg = (sum / book.rates?.length) || 0;
                        // console.log(avg, books)
                        return `<div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="/book-detail/${book.slug}">
                                            <img src="${book.image}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="/book-detail/${book.slug}">
                                            <h3> ${book.title} </h3>
                                        </a>
                                    </div>
                                    <div class="book-card__author">
                                    ${book.authors.map(item => { return `${item.name}` })}
                                    </div>
                                    <div class="book-card__star">
                                    ${(function rates() {
                                let a = ''
                                for ($i = 1; $i <= 5; $i++) {
                                    if (avg > $i) {
                                        a += '<i class="fas fa-star"></i>'
                                    } else {
                                        a += '<i class="far fa-star"></i>'
                                    }
                                }
                                return a;
                            })()}
                                        
                                    </div>
                                    <div class="book-card__btn">
                                        <a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                        <a href="/read-online/${book.slug}" class="review-btn">Xem trước</a>
                                    </div>
                                </div>
                                `
                    }).join("");
                    $('#book-qty').empty();
                    $('#book-qty').append((books.length));
                    $('#js-search-text').html(`Tìm thấy <span id="book-qty">${books.length}</span> kết quả cho <span class="search-text-detail">"${key}"</span>`);
                    $('#js-book-card-collection').empty();
                    $('#js-book-card-collection').html(result);
                }
                if (Array.isArray(books) && books.length == 0) {
                    $('#js-book-card-collection').empty();
                    $('#js-search-text').html('Không tìm thấy kết quả nào');
                }

            },
            error: function (xhr, status, error) {
                // console.log("Error!" + xhr.error);
            },

        })
    })
    for (const item of jsFilterInput) {
        item.addEventListener("click", (e) => {
            e.stopPropagation();
        })

    }
})