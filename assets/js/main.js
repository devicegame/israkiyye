/* ============================================================
   İŞRÂKİYYE — etkileşim katmanı
   Bağımlılık yok. Tüm özellikler zarifçe geri düşer.
   ============================================================ */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var doc = document;
    var root = doc.documentElement;

    /* ---------- 1. Üst çubuk durumu + okuma ilerlemesi ---------- */
    var header = doc.querySelector('.site-header');
    var progress = doc.querySelector('.scroll-progress');
    var ticking = false;

    function onScroll() {
        var y = window.scrollY || window.pageYOffset;
        if (header) header.classList.toggle('is-scrolled', y > 24);
        if (progress) {
            var max = root.scrollHeight - window.innerHeight;
            var ratio = max > 0 ? Math.min(1, Math.max(0, y / max)) : 0;
            progress.style.transform = 'scaleX(' + ratio + ')';
        }
        parallax(y);
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(onScroll);
        }
    }, { passive: true });

    /* ---------- 2. Mobil menü ---------- */
    var toggle = doc.querySelector('.nav__toggle');
    var mobileMenu = doc.querySelector('.mobile-menu');

    function closeMenu() {
        doc.body.classList.remove('menu-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    }

    if (toggle && mobileMenu) {
        toggle.addEventListener('click', function () {
            var open = doc.body.classList.toggle('menu-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        mobileMenu.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', closeMenu);
        });
        doc.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && doc.body.classList.contains('menu-open')) {
                closeMenu();
                toggle.focus();
            }
        });
    }

    /* ---------- 3. Görünüme girince belirme ---------- */
    var revealables = doc.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window && !reduceMotion) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });
        revealables.forEach(function (el) { io.observe(el); });
    } else {
        revealables.forEach(function (el) { el.classList.add('is-visible'); });
    }

    /* ---------- 4. Kartlarda imleci takip eden nûr ---------- */
    var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    if (finePointer) {
        doc.querySelectorAll('.card').forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--mx', ((e.clientX - r.left) / r.width) * 100 + '%');
                card.style.setProperty('--my', ((e.clientY - r.top) / r.height) * 100 + '%');
            });
        });
    }

    /* ---------- 5. Hafif paralaks ---------- */
    var parallaxEls = Array.prototype.slice.call(doc.querySelectorAll('[data-parallax]'));
    function parallax(y) {
        if (reduceMotion || !parallaxEls.length) return;
        parallaxEls.forEach(function (el) {
            var speed = parseFloat(el.getAttribute('data-parallax')) || 0.06;
            var rect = el.getBoundingClientRect();
            if (rect.bottom < -200 || rect.top > window.innerHeight + 200) return;
            var offset = (rect.top + rect.height / 2 - window.innerHeight / 2) * speed;
            el.style.transform = 'translate3d(0,' + offset.toFixed(2) + 'px,0)';
        });
    }

    /* ---------- 6. Yıldız alanı ---------- */
    var canvas = doc.getElementById('starfield');
    if (canvas && canvas.getContext) {
        var ctx = canvas.getContext('2d');
        var stars = [];
        var w = 0, h = 0, dpr = Math.min(window.devicePixelRatio || 1, 2);
        var rafId = null;

        function size() {
            w = window.innerWidth;
            h = window.innerHeight;
            canvas.width = Math.floor(w * dpr);
            canvas.height = Math.floor(h * dpr);
            canvas.style.width = w + 'px';
            canvas.style.height = h + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            build();
        }

        function build() {
            var count = Math.min(190, Math.round((w * h) / 12000));
            stars = [];
            for (var i = 0; i < count; i++) {
                stars.push({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    r: Math.random() * 1.15 + 0.25,
                    a: Math.random() * 0.55 + 0.08,
                    tw: Math.random() * Math.PI * 2,
                    sp: 0.004 + Math.random() * 0.012,
                    dx: (Math.random() - 0.5) * 0.05
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, w, h);
            for (var i = 0; i < stars.length; i++) {
                var s = stars[i];
                if (!reduceMotion) {
                    s.tw += s.sp;
                    s.y += 0.02;
                    s.x += s.dx;
                    if (s.y > h + 2) { s.y = -2; s.x = Math.random() * w; }
                }
                var alpha = s.a * (0.62 + 0.38 * Math.sin(s.tw));
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(' + (s.r > 1 ? '246,231,180' : '226,214,190') + ',' + alpha.toFixed(3) + ')';
                ctx.fill();
                if (s.r > 1.05) {
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r * 4.5, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(216,178,100,' + (alpha * 0.09).toFixed(3) + ')';
                    ctx.fill();
                }
            }
            rafId = window.requestAnimationFrame(draw);
        }

        var resizeTimer = null;
        window.addEventListener('resize', function () {
            window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(size, 180);
        });

        size();
        if (reduceMotion) {
            draw();
            window.cancelAnimationFrame(rafId);
        } else {
            draw();
        }

        doc.addEventListener('visibilitychange', function () {
            if (doc.hidden) {
                window.cancelAnimationFrame(rafId);
            } else if (!reduceMotion) {
                window.requestAnimationFrame(draw);
            }
        });
    }


    /* ---------- 7. Altın zerreler ---------- */
    var motesLayer = doc.getElementById('motes');
    if (motesLayer && !reduceMotion) {
        var moteCount = window.innerWidth < 700 ? 14 : 26;
        var frag = doc.createDocumentFragment();
        for (var m = 0; m < moteCount; m++) {
            var mote = doc.createElement('span');
            mote.className = 'mote';
            var dur = 16 + Math.random() * 20;
            mote.style.left = (Math.random() * 100).toFixed(2) + 'vw';
            mote.style.animationDuration = dur.toFixed(2) + 's';
            mote.style.animationDelay = (-Math.random() * dur).toFixed(2) + 's';
            mote.style.setProperty('--o', (0.18 + Math.random() * 0.5).toFixed(2));
            mote.style.setProperty('--drift', ((Math.random() - 0.5) * 120).toFixed(0) + 'px');
            mote.style.setProperty('--s', (0.6 + Math.random() * 1.7).toFixed(2));
            frag.appendChild(mote);
        }
        motesLayer.appendChild(frag);
    }

    /* ---------- 8. Yumuşak iç bağlantılar ---------- */
    doc.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var id = link.getAttribute('href');
            if (!id || id === '#') return;
            var target = doc.querySelector(id);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
            history.replaceState(null, '', id);
        });
    });

    /* ---------- 9. İlk yükleme ---------- */
    window.addEventListener('load', function () {
        onScroll();
        doc.body.classList.add('is-loaded');
    });
    onScroll();
})();
