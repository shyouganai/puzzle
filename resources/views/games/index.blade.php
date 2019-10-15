@extends('app')

@section('content')
    <div class="row my-5" id="root">
        <input type="hidden" id="rows" value="{{ $rows }}">
        <input type="hidden" id="cols" value="{{ $cols }}">
        <input type="hidden" id="image" value="/storage/images/{{ $image }}">
        <!--<div class="mr-5" style="width: 400px" id="leftSide">
            <img id="sourceImage" style="opacity: 0.2" src="/storage/images/{{ $image }}" alt="" class="d-block mx-auto w-100">
            {{ $image }}
        </div>
        <div class="" style="width: 400px" id="rightSide">

        </div>-->
    </div>

    <script type="text/javascript">
        class Field {
            constructor(parent) {
                this.el = document.createElement('div');
                this.el.classList.add('mx-auto');
                this.el.style.width = '600px';
                this.excels = [];
                document.getElementById('root').appendChild(this.el);
            }

            get width() {
                return this.el.offsetWidth;
            }

            add(excel) {
                this.el.appendChild(excel);
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
                el.style.position = 'relative';
                el.style.left = x + 'px';
                el.style.top = y + 'px';
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
                return el;
            }
        };

        let rows = document.getElementById('rows').value;
        let cols = document.getElementById('cols').value;
        let img = document.createElement('img');
        let leftField = new Field(document.getElementById('root'));
        let rightField = new Field(document.getElementById('root'));

        img.onload = function () {
            let percent = img.width * 100 / rightField.width;
            img.width *= 100 / percent;
            img.height *= 100 / percent;
            //img.style.width = field.width + 'px';
            for (let i = 0; i < rows; i++) {
                for (let j = 0; j < cols; j++) {
                    let x = j * img.width / cols;
                    let y = i * img.height / rows;
                    let width = img.width / cols;
                    let height = img.height / rows;
                    rightField.add(new Excel(x, y, width, height, rightField, img));
                }
            }
        };
        //document.body.appendChild(img);
        img.src = document.getElementById('image').value;

        //document.getElementById('sourceImage').style.width = document.getElementById('rightSide').offsetWidth + 'px';
        /*let img = document.createElement('img');
        let rows = document.getElementById('rows').value;
        let cols = document.getElementById('cols').value;
        document.getElementById('sourceImage').onload = function() {
            let width = document.getElementById('leftSide').offsetWidth / rows;//this.width / rows;
            let height = document.getElementById('leftSide').offsetHeight / cols;//this.height / cols;
            for (let i = 0; i < rows; i++) {
                let row = document.createElement('div');
                row.classList.add('row');
                for (let j = 0; j < cols; j++) {
                    let puzzle = document.createElement('div');
                    puzzle.style.overflow = 'hidden';
                    puzzle.style.width = width + 'px';
                    puzzle.style.height = height + 'px';
                    puzzle.onmousedown = function (e) {
                        puzzle.style.position = 'absolute';
                        moveAt(e);
                        document.body.appendChild(puzzle);

                        function moveAt(e) {
                            puzzle.style.left = e.pageX - puzzle.offsetWidth / 2 + 'px';
                            puzzle.style.top = e.pageY - puzzle.offsetHeight / 2 + 'px';
                        }

                        document.onmousemove = function (e) {
                            moveAt(e);
                        }

                        document.onmouseup = function () {
                            document.onmousemove = null;
                            puzzle.onmouseup = null;
                        }
                    };
                    puzzle.ondragstart = function() {
                        return false;
                    }
                    let cropImage = document.createElement('img');
                    cropImage.style.width = document.getElementById('leftSide').offsetWidth + 'px';
                    cropImage.style.height = document.getElementById('leftSide').offsetHeight + 'px';
                    cropImage.style.position = 'relative';
                    cropImage.style.left = (-j*width) + 'px';
                    cropImage.style.top = (-i*height) + 'px';
                    cropImage.src = document.getElementById('sourceImage').src;
                    puzzle.appendChild(cropImage);
                    row.appendChild(puzzle);
                }
                document.getElementById('rightSide').appendChild(row);
            }
        }*/
        //img.src = document.getElementById('image').value;
        //document.getElementById('leftSide').remove();
    </script>
@endsection
