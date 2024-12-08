document.addEventListener("DOMContentLoaded", () => {
    const genreLinks = document.querySelectorAll('.dropdown-content a');
    const movies = document.querySelectorAll('.movie');
    const homeLink = document.getElementById('homeLink'); 
    
    homeLink.addEventListener('click', () => {
        movies.forEach(movie => {
            movie.style.display = "block";
        });
    });

    genreLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const selectedGenre = link.getAttribute('data-genre');
            let hasResults = false;

            movies.forEach(movie => {
                const movieGenres = movie.querySelector('p').textContent;
                if (movieGenres.includes(selectedGenre)) {
                    movie.style.display = "block";
                    hasResults = true;
                } else {
                    movie.style.display = "none";
                }
            });
            if (!hasResults) {
                alert("Nuk ka seriale për këtë zhanër."); 
            }
        });
    });
});
