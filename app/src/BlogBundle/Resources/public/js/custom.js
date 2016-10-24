$(function () {
    function strReplaceAll(string, Find, Replace) {
        try {
            return string.replace(new RegExp(Find, "gi"), Replace);
        } catch (ex) {
            return string;
        }
    }

    var container = $('#product_images'), block = container.attr('data-prototype'), i = 0;
    $('#add').click(function () {
        var str = strReplaceAll(block, '__name__', i);
        i = i + 1;
        container.append(str);
    })

    $('input:file').change(function (e) {
        console.log(123123);
        var cont = $('.'+$(this).attr('id')+'preview');
        $(cont).empty();
        if (this.files && this.files[0]) {
            for (i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                if (this.files[i].type == 'image/jpg' || this.files[i].type == 'image/jpeg' || this.files[i].type == 'image/png') {
                    reader.onload = function (e) {
                        var img = $(
                            '<div class="prew-img"><a href="#" onclick="" image-id='+i+'><span class="fa fa-remove text-danger"></span></a><img src='+e.target.result+' id='+i+' width="50px"></div>'
                        );
                        // img.attr('src', e.target.result);
                        img.appendTo(cont);
                    };
                }
                reader.readAsDataURL(this.files[i]);
            }
        }
    });

});
