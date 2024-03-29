@extends('app')

@section('content')
    <div class="row my-5" id="root">
        <input type="hidden" id="rows" value="{{ $rows }}">
        <input type="hidden" id="cols" value="{{ $cols }}">
        <input type="hidden" id="image" value="/storage/images/{{ $image }}">
    </div>

    <script type="text/javascript">
        class Field {
            constructor(parent) {
                this.el = document.createElement('div');
                this.el.classList.add('mx-auto');
                this.el.style.width = '600px';
                this.x = 0;
                this.y = 0;
                this.excels = [];
                document.getElementById('root').appendChild(this.el);
            }

            get width() {
                return this.el.offsetWidth;
            }

            add(excel) {
                excel.getEl().style.left = this.x * excel.width + 'px';
                excel.getEl().style.top = this.y * excel.height + 'px';
                this.x++;
                if (this.x == cols) {
                    this.x = 0;
                    this.y++;
                }
                this.el.appendChild(excel.getEl());
            }
        };

        class Excel {
            constructor(x, y, width, height, parent, image) {
                this.x = x;
                this.y = y;
                this.width = width;
                this.height = height;
                this.parent = parent;
                this.image = image;

                let el = document.createElement('div');
                el.style.position = 'absolute';
                /*el.style.left = x + 'px';
                el.style.top = y + 'px';*/
                el.style.overflow = 'hidden';
                el.style.width = width + 'px';
                el.style.height = height + 'px';
                el.onmousedown = function(e) {
                    el.style.position = 'absolute';
                    moveAt(e);
                    document.body.appendChild(el);

                    function moveAt(e) {
                        el.style.left = e.pageX - el.offsetWidth / 2 + 'px';
                        el.style.top = e.pageY - el.offsetHeight / 2 + 'px';
                    }

                    document.onmousemove = function (e) {
                        moveAt(e);
                    }

                    document.onmouseup = function () {
                        document.onmousemove = null;
                        el.onmouseup = null;
                    }
                };
                el.ondragstart = function() {
                    return false;
                };

                this.img = document.createElement('img');
                this.img.width = image.width;
                this.img.height = image.height;
                this.img.style.position = 'relative';
                this.img.style.left = -x + 'px';
                this.img.style.top = -y + 'px';
                this.img.src = image.src;

                el.appendChild(this.img);
                this.el = el;
            }

            getEl() {
                return this.el;
            }
        };

        function shuffle(array) {
            array.sort(() => Math.random() - 0.5);
        }

        var rows = document.getElementById('rows').value;
        var cols = document.getElementById('cols').value;
        let img = document.createElement('img');
        let leftField = new Field(document.getElementById('root'));
        let rightField = new Field(document.getElementById('root'));

        img.onload = function () {
            let percent = img.width * 100 / rightField.width;
            img.width *= 100 / percent;
            img.height *= 100 / percent;
            let excels = [];
            //img.style.width = field.width + 'px';
            for (let i = 0; i < rows; i++) {
                for (let j = 0; j < cols; j++) {
                    let x = j * img.width / cols;
                    let y = i * img.height / rows;
                    let width = img.width / cols;
                    let height = img.height / rows;
                    excels.push(new Excel(x, y, width, height, rightField, img));
                }
            }
            shuffle(excels);
            for (let i = 0; i < excels.length; i++)
                rightField.add(excels[i]);
        };
        img.src = document.getElementById('image').value;
    </script>
@endsection
