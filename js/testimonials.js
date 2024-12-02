document.addEventListener("DOMContentLoaded", function () {
    const testimonials = document.querySelectorAll(".testimonial-item");
    const dotsContainer = document.createElement("div");
    dotsContainer.className = "testimonial-dots";
    const testimonialsSection = document.querySelector(".testimonials-section");
    let currentIndex = 0; // شروع از اولین آیتم
    let interval;

    if (testimonials.length > 1) {
        // Create dots
        testimonials.forEach((_, index) => {
            const dot = document.createElement("span");
            dot.className = "dot";
            if (index === 0) dot.classList.add("active");
            dot.addEventListener("click", () => {
                goToTestimonial(index);
                resetInterval();
            });
            dotsContainer.appendChild(dot);
        });
        testimonialsSection.appendChild(dotsContainer);

        // Start autoplay immediately
        goToTestimonial(0); // نشان دادن اولین تستیمونیال بلافاصله
        interval = setInterval(nextTestimonial, 10000);

        // Keyboard navigation
        document.addEventListener("keydown", (e) => {
            if (e.key === "ArrowRight") {
                nextTestimonial();
                resetInterval();
            } else if (e.key === "ArrowLeft") {
                prevTestimonial();
                resetInterval();
            }
        });
    }

    function goToTestimonial(index) {
        testimonials[currentIndex]?.classList.remove("active");
        dotsContainer.children[currentIndex]?.classList.remove("active");
        currentIndex = index;
        testimonials[currentIndex]?.classList.add("active");
        dotsContainer.children[currentIndex]?.classList.add("active");
    }

    function nextTestimonial() {
        const nextIndex = (currentIndex + 1) % testimonials.length;
        goToTestimonial(nextIndex);
    }

    function prevTestimonial() {
        const prevIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
        goToTestimonial(prevIndex);
    }

    function resetInterval() {
        clearInterval(interval);
        interval = setInterval(nextTestimonial, 10000);
    }
});
