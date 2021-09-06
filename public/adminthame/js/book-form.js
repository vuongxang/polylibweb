var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
    removeItemButton: true,
    maxItemCount: 5,
    searchResultLimit: 5,
    renderChoiceLimit: 5
});

$(document).ready(function () {
    $('#image_gallery').on('hide.bs.modal', function () {
        var image_list = $('input#list_image').val();
        if (image_list.length > 0) {
            if (/^[\],:{}\s]*$/.test(image_list.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                var image_gallery = $.parseJSON(image_list);
                console.log(image_gallery);
                var html = '';
                image_gallery.forEach((item, index) => {
                    html +=
                        `<div class="col-2 text-center">
                            <span aria-hidden="true" value="${item}" style="width:20px; height:20px;z-index:10;right:0;top:0;transform:translateY(-50%)" class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center rounded-circle position-absolute  cancle-image"><i class="fas fa-times"></i></span>
                            <div class="card">
                                <img src="${item}" alt="" id="show_list_img" width="100%">
                            </div>
                        </div>`;
                });
                $('.img-gallery').html(html);
            } else {
                html =
                    `<div class="col-2">
                        <span aria-hidden="true" value="${image_list}" style="width:20px; height:20px;z-index:10;right:0;top:0;transform:translateY(-50%)" class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center rounded-circle position-absolute  cancle-image"><i class="fas fa-times"></i></span>
                        <div class="card">
                            <img src="${image_list}" alt="" id="show_list_img" width="100%">
                        </div>
                    </div>`;
                $('.img-gallery').html(html);
            }
        }
        //Xóa ảnh gallery khi sửa sách
        let cancle_image_class = [...$('.cancle-image')];
        let list_image = document.querySelector('#list_image');
        let image_filtered = [];
        cancle_image_class.forEach(item => {
            item.addEventListener("click", function () {
                let url = item.getAttribute('value');
                if (/^[\],:{}\s]*$/.test(list_image.value.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                    /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                    .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                    let image_array = $.parseJSON(list_image.value);
                    console.log(image_array);
                    console.log(url);
                    image_filtered = image_array.filter(function (item, index, arr) {
                        return item != url;
                    });
                } else {
                    image_filtered = [];
                }

                list_image.value = JSON.stringify(image_filtered)
                item.parentNode.remove();
            });
        })
    })

    $('#audio_gallery').on('hide.bs.modal', function () {
        var audio_list = $('input#list_audio').val();
        if (audio_list.length) {
            if (/^[\],:{}\s]*$/.test(audio_list.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                var audio_gallery = $.parseJSON(audio_list);
                var html = '';
                audio_gallery.forEach((item, index) => {
                    html +=
                        `<div class="d-flex align-items-center mb-1">
                            <audio src="${item}" id="show_list_audio" controls>
                            Trình duyệt không hỗ trợ phát âm thanh
                            </audio>
                            <span aria-hidden="true" value="${item}" class="font-weight-bold btn btn-outline-dark cancle-audio">&#10006</span>
                        </div>`;
                });
                $('.audio-gallery').html(html);
            } else {
                console.log(audio_list);
                html = `<div class="d-flex align-items-center">
                            <audio src="${audio_list}" id="show_list_audio" controls>
                            Trình duyệt không hỗ trợ phát âm thanh
                            </audio>
                            <span aria-hidden="true" value="${audio_list}" class="btn btn-outline-dark cancle-audio">&#10006</span>
                        </div>`;
                $('.audio-gallery').html(html);
            }
            let x = [...$('.cancle-audio')];
            let list_audio = document.querySelector('#list_audio');
            let filtered = [];
            x.forEach(item => {
                item.addEventListener("click", function () {
                    let url = item.getAttribute('value');
                    if (/^[\],:{}\s]*$/.test(list_audio.value.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                        /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                        .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                        let audio_array = $.parseJSON(list_audio.value);
                        filtered = audio_array.filter(function (item, index, arr) {
                            return item != url;
                        });
                    } else {
                        filtered = [];
                    }

                    list_audio.value = JSON.stringify(filtered)
                    item.parentNode.remove();
                });
            })
        }
    })

    let x = [...$('.cancle-audio')];
    let list_audio = document.querySelector('#list_audio');
    x.forEach(item => {
        item.addEventListener("click", function () {
            let url = item.getAttribute('value');
            let audio_array = $.parseJSON(list_audio.value);
            console.log(audio_array);
            let filtered = audio_array.filter(function (item, index, arr) {
                return item != url;
            });
            console.log(filtered);
            list_audio.value = JSON.stringify(filtered)
            item.parentNode.remove();
        });
    })

    //Xóa ảnh gallery khi sửa sách
    let cancle_image_class = [...$('.cancle-image')];
    let list_image = document.querySelector('#list_image');

    cancle_image_class.forEach(item => {
        item.addEventListener("click", function () {
            let url = item.getAttribute('value');
            let image_array = $.parseJSON(list_image.value);
            console.log(image_array);
            console.log(url);
            let image_filtered = image_array.filter(function (item, index, arr) {
                return item != url;
            });

            console.log(image_filtered);
            list_image.value = JSON.stringify(image_filtered)
            item.parentNode.remove();
        });
    })

})

