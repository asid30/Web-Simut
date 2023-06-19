<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.js"></script>

<nav class="navbar navbar-expand-lg bg-dark-subtle">
<div class="container-fluid">
    <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Menu</button>
    <a class="navbar-brand"><h4> S I M U T </h4></a>
    <ul class="navbar-nav">
        <b>Time :</b> 
        <div id="sketch-holder">
            <script>
            function setup() {
                var canvas = createCanvas(120, 30);
                canvas.parent('sketch-holder');
            }
            function draw() {
                function addZero(i) {
                    if (i < 10) {
                        i = "0" + i
                    }
                    return i;
                }
                const d = new Date();
                let h = addZero(d.getHours());
                let m = addZero(d.getMinutes());
                let s = addZero(d.getSeconds());
                let time = h + " : " + m + " : " + s + " WIB";
                background('#ced4da');
                // background(220);
                textSize(15);
                text(time, 3, 18);
                fill(240, 20, 20);
                textStyle(BOLD);
                textFont('Helvetica');
            }
            </script>
        </div>
    </ul>
</div>
</nav>