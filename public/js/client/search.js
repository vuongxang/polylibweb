$(function($) {
    let jsFilterItem = document.getElementsByClassName('js-filter-item');
    let jsFilterInput = document.getElementsByClassName('filter-item__input');

    let cates = []


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
    
    const keyword = decodeURI(GetURLParameter('keyword'))
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
                success: function(res) {
                    const books = [...res[0]];
                    const key = [res[1]];
                    if (Array.isArray(books) && books.length > 0) {
                        const result = books.map((book) => {
                            return `<div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="/book-detail/${book.id}">
                                            <img src="${book.image}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="/book-detail/${book.id}">
                                            <h3> ${book.title} </h3>
                                        </a>
                                    </div>
                                    <div class="book-card__author">
                                    ${book.authors.map(item=>{return ` ${item.name}`})}
                                    </div>
                                    <div class="book-card__star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="book-card__btn">
                                        <a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                        <a href="/read-online/${book.id}" class="review-btn">Xem trước</a>
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
                error: function(xhr, status, error) {
                    console.log("Error!" + xhr.error);
                },

            })
            // }
        })
    }

    $('#filter-form :checkbox').change(function() {
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
            success: function(res) {
                const books = [...res[0]];
                const key = [res[1]];
                if (Array.isArray(books) && books.length > 0) {
                    const result = books.map((book) => {
                        return `<div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="/book-detail/${book.id}">
                                            <img src="${book.image}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="/book-detail/${book.id}">
                                            <h3> ${book.title} </h3>
                                        </a>
                                    </div>
                                    <div class="book-card__author">
                                    ${book.authors.map(item=>{return `${item.name}`})}
                                    </div>
                                    <div class="book-card__star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="book-card__btn">
                                        <a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                        <a href="/read-online/${book.id}" class="review-btn">Xem trước</a>
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
            error: function(xhr, status, error) {
                console.log("Error!" + xhr.error);
            },

        })
    })
    for (const item of jsFilterInput) {
        item.addEventListener("click", (e) => {
            e.stopPropagation();
        })

    }
})