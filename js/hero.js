// document.addEventListener("DOMContentLoaded", () => {
//     const sliders = document.querySelectorAll(".hero-image");

//     sliders.forEach((slider) => {
//         const images = slider.querySelectorAll(".hero-image-wrapper");

//         // عرض هر تصویر
//         const imageWidth = 160; // به دلخواه یا متناسب با CSS
//         const sliderWidth = slider.offsetWidth;

//         images.forEach((image, index) => {
//             // موقعیت اولیه تصاویر بر اساس ترتیب
//             image.style.position = "absolute";
//             image.style.left = `${index * imageWidth}px`; // فاصله افقی
//         });

//         const animate = () => {
//             images.forEach((image) => {
//                 const currentLeft = parseFloat(image.style.left);

//                 // اگر تصویر از کادر خارج شد، دوباره به انتها برگردد
//                 if (currentLeft <= -imageWidth) {
//                     image.style.left = `${sliderWidth}px`;
//                 } else {
//                     // حرکت تصویر به سمت چپ
//                     image.style.left = `${currentLeft - 1}px`;
//                 }
//             });

//             // درخواست انیمیشن بعدی
//             requestAnimationFrame(animate);
//         };

//         // شروع انیمیشن
//         animate();
//     });
// });
