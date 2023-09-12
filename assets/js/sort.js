const sortSelector = document.getElementById('sortAnnonce');
const typeSelector = document.getElementById('typeAnnonce');


sortSelector.addEventListener('change', () => {
    updateURLParams();
});
  
typeSelector.addEventListener('change', () => {
    updateURLParams();
});
  
function updateURLParams() {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
  
    const sortValue = sortSelector.value;
    const typeValue = typeSelector.value;

    if (sortValue) {
      params.set('sort', sortValue);
    } else {
      params.delete('sort');
    }
  
    if (typeValue) {
      params.set('type', typeValue);
    } else {
      params.delete('type');
    }
  
    url.search = params.toString();
  
    if (window.location.hash) {
      window.location.href = url.href.replace(window.location.hash, '') + '#annonces';
    } else {
      window.location.href = url.href+'#annonces';
    }
};

function goToAnchor() {
    const annonce = document.getElementById('annonces');
    annonce.scrollIntoView();
}
