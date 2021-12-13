// carousel

(function(){
let slideIndex = 1

const showSlides = () => {
    const slides = document.getElementsByClassName('slide')
    for (let i = 0; i < slides.length; ++i) {
    slides[i].style.display = 'none'
    }
    ++slideIndex
    if (slideIndex > slides.length) {
    slideIndex = 1
    }
    slides[slideIndex - 1].style.display = 'block'
    setTimeout(showSlides, 15000)
}
showSlides() 
})()



// carousel avec fleche

let slideIndex = 1 ;

const previousSlide = () => {
    showSlide(slideIndex -= 1);
}
const nextSlide = () => {
    showSlide(slideIndex += 1);
}

const showSlide = (number) => {
    slideIndex= number;
    const slides = document.querySelectorAll('.slide');
    // const dots = document.querySelectorAll('.dot');
    if (number > slides.length) {
    slideIndex = 1;
    }
    if (number < 1) {
    slideIndex = slides.length;
    }
    for(let i = 0; i < slides.length; ++i) {
    if(i + 1 === slideIndex) {
        slides[i].style.display = 'block';
    } else {
        slides[i].style.display = 'none';
    }
    }
    // for (let i = 0; i < slides.length; ++i) {
    // if (i + 1 === slideIndex){
    //     dots[i].classList.add('active');
    // } else {
    //     dots[i].classList.remove('active');
    // }
    // }  
}

showSlide(slideIndex);