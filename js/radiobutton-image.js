            $(function() {
                $('input:radio').hide().each(function() {
                    var label = $("label[for=" + '"' + this.id + '"' + "]").text();
                    $('<a ' + (label != '' ? 'title=" ' + label + ' "' : '' ) + ' class="radio-fx ' + this.name + '" href="#"><span class="radio' + (this.checked ? ' radio-checked' : '') + '"></span></a>').insertAfter(this);
                });
                $('.radio-fx').on('click', function(e) {
                    $check = $(this).prev('input:radio');
                    var unique = '.' + this.className.split(' ')[1] + ' span';
                    $(unique).attr('class', 'radio');
                    $(this).find('span').attr('class', 'radio-checked');
                    $check.attr('checked', true);
                }).on('keydown', function(e) {
                    if ((e.keyCode ? e.keyCode : e.which) == 32) {
                        $(this).trigger('click');
                    }
                });
                /* not needed just for sake ;)*/
                $('#form').submit(function() {
                    var posts = $(this).serialize();
                    if (posts != '') {
                        alert(posts);
                    } else {
                        alert('please select something, then submit the form!');
                    }
                    return false;
                });
                $('#change-skin').change(function() {
                    $('form table').attr('id', this.value);
                });
            });
