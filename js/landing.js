document.addEventListener("DOMContentLoaded", function () {

    /* ================= PRIORITIES CAROUSEL ================= */
    const cards = document.querySelectorAll(".priority-card");
    let index = 0;
    let autoSlideInterval;

    function updateCarousel() {
        cards.forEach((card, i) => {
            card.classList.remove("active", "side");

            if (i === index) {
                card.classList.add("active");
            } else {
                card.classList.add("side");
            }
        });
    }

    function autoSlide() {
        index = (index + 1) % cards.length;
        updateCarousel();
    }

    function startAutoSlide() {
        autoSlideInterval = setInterval(autoSlide, 3000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    if (cards.length > 0) {
        updateCarousel();
        startAutoSlide();

        cards.forEach(card => {
            card.addEventListener("mouseenter", stopAutoSlide);
            card.addEventListener("mouseleave", startAutoSlide);
        });
    }


    /* ================= PRIORITY MODAL ================= */
    const priorityModal = document.getElementById("priorityModal");
    const modalTitle = document.getElementById("modalTitle");
    const modalImage = document.getElementById("modalImage");
    const closePriorityModal = document.querySelector(".close-modal");

    if (priorityModal && modalTitle && modalImage) {

        cards.forEach(card => {
            card.addEventListener("click", () => {

                const title = card.querySelector("p")?.innerText || "";
                const img = card.querySelector("img")?.src || "";

                modalTitle.innerText = title;
                modalImage.src = img;

                priorityModal.classList.add("active");
            });
        });

        if (closePriorityModal) {
            closePriorityModal.addEventListener("click", () => {
               priorityModal.classList.remove("active");
            });
        }

        window.addEventListener("click", (e) => {
            if (e.target === priorityModal) {
                priorityModal.style.display = "none";
            }
        });
    }


    /* ================= ACCORDION (SMOOTH + CLEAN) ================= */
document.querySelectorAll(".accordion-header").forEach(header => {
    header.addEventListener("click", () => {
        const item = header.parentElement;

        // close other items (premium feel)
        document.querySelectorAll(".accordion-item").forEach(i => {
            if (i !== item) i.classList.remove("active");
        });

        // toggle current
        item.classList.toggle("active");
    });
});


    /* ================= NAVIGATION ================= */
    const salesLink = document.getElementById("salesLink");
    const careerLink = document.getElementById("careerLink");

    if (salesLink) {
        salesLink.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.href = "user/sales_application.php";
        });
    }

    if (careerLink) {
        careerLink.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.href = "user/fa_application.php";
        });
    }

});


/* ================= TOP MODAL ================= */
window.addEventListener('load', () => {
    const topModal = document.getElementById('topModal');
    const closeBtn = document.querySelector('.top-modal .close-btn');

    if (topModal) {
        setTimeout(() => {
            topModal.classList.add('active');
        }, 300);

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                topModal.classList.remove('active');
            });
        }

        setTimeout(() => {
            topModal.classList.remove('active');
        }, 5000);
    }
});