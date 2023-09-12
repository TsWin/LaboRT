const sortSelector = document.getElementById('sortReservation');



sortSelector.addEventListener('change', () => {
    updateURLParams();
});

  
function updateURLParams() {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
  
    const sortValue = sortSelector.value;

    if (sortValue) {
      params.set('sort', sortValue);
    } else {
      params.delete('sort');
    }
  
    url.search = params.toString();
  
    if (window.location.hash) {
      window.location.href = url.href.replace(window.location.hash, '') + '#annonces';
    } else {
      window.location.href = url.href+'#annonces';
    }
};
