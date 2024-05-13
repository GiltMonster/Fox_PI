class Slideshow {
  constructor(container) {
      this.container = container;
      this.slideIndex = 1;
      this.slides = this.container.getElementsByClassName("mySlides");
      this.dots = this.container.getElementsByClassName("dot");
      if (this.slides.length > 0) {
          this.showSlides(this.slideIndex);
      }
  }

  plusSlides(n) {
      this.showSlides(this.slideIndex += n);
  }

  currentSlide(n) {
      this.showSlides(this.slideIndex = n);
  }

  showSlides(n) {
      if (this.slides.length === 0) return; // Verifica se existem slides
      if (n > this.slides.length) { this.slideIndex = 1; }
      if (n < 1) { this.slideIndex = this.slides.length; }
      for (let slide of this.slides) {
          slide.style.display = "none";
      }
      for (let dot of this.dots) {
          dot.className = dot.className.replace(" active", "");
      }
      this.slides[this.slideIndex - 1].style.display = "block";
      this.dots[this.slideIndex - 1].className += " active";
  }
}

// Inicialize o carrossel para cada contêiner de slideshow
let slideshowContainers = document.getElementsByClassName("slideshow-container");
for (let container of slideshowContainers) {
    let slideshow = new Slideshow(container);
    container.slideshowInstance = slideshow; // Atribua a instância da classe Slideshow ao contêiner
}

