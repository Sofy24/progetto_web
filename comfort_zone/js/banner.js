let bannerIndex = 0;

function showBanners() {
    try {
        let i;
        const slides = document.getElementsByClassName("banners");
        const dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        bannerIndex++;
        if (bannerIndex > slides.length) {bannerIndex = 1}    
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
    
        slides[bannerIndex-1].style.display = "block";
        dots[bannerIndex-1].className += " active";
        setTimeout(showBanners, 4000); // Change image every 2 seconds
    } catch (error) {}
}

$(document).ready(function(){
        showBanners();
    });