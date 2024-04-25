var myCanvas = document.getElementById('canvasConfetti');
const plank = document.getElementById('woodPlank').getBoundingClientRect();

window.addEventListener('DOMContentLoaded', (e) => {
    window.myConfetti = confetti.create(myCanvas, {
        resize: true,
        useWorker: true
    });
});

window.addEventListener('load', e => {
    burstConfetti(
        plank.x + plank.width / 2,
        plank.y + plank.height / 2
    );
    setTimeout(e => {
        burstConfetti(
            plank.x + plank.width / 2,
            plank.y + plank.height / 2
        );

    }, 300)
});

function burstConfetti(posX, posY) {
    var count = 200;
    const cover = document.querySelector('.cover-image');
    const rect = cover.getBoundingClientRect();
    const x = (posX - rect.left) / cover.clientWidth;
    const y = (posY - rect.top) / cover.clientHeight + .05;
    var defaults = {
        origin: { x: x, y: y },
        gravity: 0.5,
        scalar: .9,
        drift: 1,
        ticks: 150,
        angle: randomInRange(85, 95),
        colors: ['#fe9400', '#002408', '#c7a458', '#D4AF37', '#C0C0C0']
    };

    function fire(particleRatio, opts) {
        myConfetti(Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio)
        }));
    }

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    fire(0.25, {
        spread: 50,
        startVelocity: 70,
        decay: 0.82,
        scalar: 0.7,
        disableForReducedMotion: true,
    });
    fire(0.2, {
        spread: 60,
        startVelocity: 120,
        decay: 0.70,
        disableForReducedMotion: true,
    });
    fire(0.35, {
        spread: 40,
        startVelocity: 75,
        decay: 0.71,
        scalar: 0.8,
        disableForReducedMotion: true
    });
    fire(0.1, {
        spread: 60,
        startVelocity: 65,
        decay: 0.87,
    });
    fire(0.1, {
        spread: 60,
        decay: 0.7,
        startVelocity: 75,
        disableForReducedMotion: true
    });

}
