<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"> -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/bookDetail.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="grid">
            <header class="header">
                <div class="header__logo">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img">
                </div>
                <ul class="header__nav">
                    <li class="header__nav-li"><a class="link" href="">Trang Chủ</a></li>
                    <li class="header__nav-li"><a class="link" href="">Danh Mục</a></li>
                    <li class="header__nav-li"><a class="link" href="">Tin Tức</a></li>
                </ul>
                <div class="header__search">
                    <form action="" class="header__search-form">
                        <input class="header__search-input" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
                        <button class="header__search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="header__information">
                    <div class="header__information-notification">
                        <img src="{{asset('images/notification.svg')}}" alt="">
                    </div>
                    <div class="header__information-info">
                        <img src="{{asset('images/avatar.png')}}" alt="">
                        <i class="fas fa-caret-down"></i>
                    </div>
                </div>
            </header>
            <main>
                <div class="book-detail">
                    <div class="book-detail__image">
                        <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                    </div>
                    <div class="book-detail__content">
                        <div class="book-detail-content__header">
                            <h2>Nguồn Cội (Robert Langdon #5)</h2>
                            <p>Tác giả: <span class="book-detail-content__header-author"> Dan Brown </span></p>
                            <p>Đánh giá: <span class="book-detail-content__header-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-detail-content__button">
                            <button class="borrow-btn">Muợn sách</button>
                            <button class="review-btn">Xem trước</button>
                        </div>
                        <div class="book-detail-content__desc">
                            <h3>Mô tả sách</h3>
                            <p>Robert Langdon, giáo sư biểu tượng và biểu tượng tôn giáo đến từ trường đại học Harvard, đã tới Bảo tàng Guggenheim Museum Bilbao để tham dự một tuyên bố quan trọng - công bố phát hiện "sẽ thay đổi bộ mặt khoa học mãi mãi".<br />

                                Edmond Kirsch - một tỷ phú bốn mươi tuổi, một nhà tiên tri với những phát minh kỹ thuật cao và những dự đoán táo bạo đã làm cho anh trở thành một nhân vật nổi tiếng toàn cầu. Kirsch - cũng chính là một trong những sinh viên đầu tiên của Langdon tại đại học Harvard cách đây hai thập kỷ - sẽ tiết lộ một bước đột phá đáng kinh ngạc... Một trong số đó sẽ trả lời hai câu hỏi cơ bản về sự tồn tại của con người:
                                <br /><br />
                                "Chúng ta đến từ đâu?" và "Chúng ta đang đi về đâu?"
                                <br /><br />
                                Khi sự kiện bắt đầu, Langdon và vài trăm quan khách cảm thấy bị cuốn hút bởi một bài thuyết trình được trình hoàn toàn độc đáo, mà chính Langdon cũng nhận thấy rằng sẽ gây ra nhiều tranh cãi hơn những gì ông tưởng tượng. Nhưng buổi tối được chuẩn bị chu toàn này đột nhiên biến thành sự hỗn loạn, và khám phá quý giá của Kirsch đang dần dần biến mất. Trước nguy cơ phải đối mặt với một mối đe dọa sắp xảy ra, Langdon bị buộc phải bỏ trốn để thoát khỏi Bilbao. Đi cùng ông là Ambra Vidal, nữ giám đốc viện bảo tàng thanh lịch, người đã cùng Kirsch chuẩn bị cho sự kiện này đồng thời cũng là Hoàng hậu tương lai của đất nước Tây Ban Nha. Họ cùng nhau chạy trốn đến Barcelona trong một cuộc hành trình nguy hiểm để tìm ra một mật khẩu bí ẩn sẽ mở ra bí mật của Kirsch.
                                ..

                            </p>
                        </div>
                        <div class="book-detail-content__tag">
                            <button>Truyện</button>
                            <button>Tiểu thuyết nước ngoài</button>
                        </div>
                    </div>

                </div>

                <div class="book-comment">
                    <div class="book-comment__tab">
                        <button class="book-comment__button book-comment__button--active">Bình luận</button>
                        <button class="book-comment__button">Phản hồi </button>
                        <button class="book-comment__button">Đánh giá</button>
                    </div>
                    <div class="book-comment__body">
                        <div class="book-comment-body__detail">
                            <div class="book-comment-body-detail__img">
                                <img src="{{asset('images/avatar.png')}}" alt="">
                            </div>
                            <div class="book-comment-body-detail__content">
                                <div class="book-comment-body-detail__username">Trần Văn A</div>
                                <div class="book-comment-body-detail__date">01/06/2021</div>
                                <div class="book-comment-body-detail__comment">Đáng đọc, truyện hay lôi cuốn và đầy bất ngờ</div>
                            </div>
                        </div>
                        <div class="book-comment-body__detail">
                            <div class="book-comment-body-detail__img">
                                <img src="{{asset('images/avatar.png')}}" alt="">
                            </div>
                            <div class="book-comment-body-detail__content">
                                <div class="book-comment-body-detail__username">Trần Văn A</div>
                                <div class="book-comment-body-detail__date">01/06/2021</div>
                                <div class="book-comment-body-detail__comment">Đáng đọc, truyện hay lôi cuốn và đầy bất ngờ</div>
                            </div>
                        </div>
                        <div class="book-comment-body__detail">
                            <div class="book-comment-body-detail__img">
                                <img src="{{asset('images/avatar.png')}}" alt="">
                            </div>
                            <div class="book-comment-body-detail__content">
                                <div class="book-comment-body-detail__username">Trần Văn A</div>
                                <div class="book-comment-body-detail__date">01/06/2021</div>
                                <div class="book-comment-body-detail__comment">Đáng đọc, truyện hay lôi cuốn và đầy bất ngờ</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="book-same book__same--category">
                    <div class="book-same__heading space__between">
                        <h2>Sách cùng thể loại</h2>
                        <a href="">Xem thêm</a>
                    </div>
                    <div class="book-same__body space__between">


                        <div class="book-item">
                            <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                            <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            <p> <span class="book-author"> Dan Brown </span></p>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                            <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            <p> <span class="book-author"> Dan Brown </span></p>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                            <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            <p> <span class="book-author"> Dan Brown </span></p>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                            <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            <p> <span class="book-author"> Dan Brown </span></p>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>

                    </div>

                </div>


                <div class="book-same book__same--author">
                    <div class="book-same__heading space__between">
                        <h2>Sách cùng tác giả</h2>
                        <a href="">Xem thêm</a>
                    </div>
                    <div class="book-same__body space__between">

                        <div class="book-item">
                            <a href="">
                                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            </a>
                            <a href="">
                                <p> <span class="book-author"> Dan Brown </span></p>
                            </a>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <a href="">
                                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            </a>
                            <a href="">
                                <p> <span class="book-author"> Dan Brown </span></p>
                            </a>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <a href="">
                                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            </a>
                            <a href="">
                                <p> <span class="book-author"> Dan Brown </span></p>
                            </a>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                        <div class="book-item">
                            <a href="">
                                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                            </a>
                            <a href="">
                                <p> <span class="book-author"> Dan Brown </span></p>
                            </a>
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>

                    </div>

                </div>
            </main>

        </div>
        <footer class="full-width">
            <div class="grid">

                <div class="footer-about">
                    <img class="footer-about-logo" src="{{asset('images/logo.png')}}" alt="">
                    <ul class="footer-about-body">
                        <li><a href="">Giới thiệu </a></li>
                        <li><a href="">Danh sách tác giả </a></li>
                        <li><a href="">Điều khoản dịch vụ </a></li>
                        <li><a href="">Chính sách bảo mật </a></li>
                    </ul>
                </div>
                <div class="footer-category">
                    <h3 class="footer-category-heading">Danh mục nổi bật</h3>
                    <ul class="footer-category-body">
                        <li><a href="">Nhiếp ảnh, dựng phim </a></li>
                        <li><a href="">Nuôi dạy con </a></li>
                        <li><a href="">Phong cách sống </a></li>
                        <li><a href="">Sức khỏe giới tính </a></li>
                    </ul>
                </div>
            </div>

        </footer>
    </div>
</body>

</html>