const select = document.querySelector('.js-select');
const button = document.querySelector('.js-button');
const wrapper = document.querySelector('.js-recipes');
let recipes = [];

const drawRecipes = (type) => {
  const fittingRecipes = type === 'wszystkie'
    ? recipes
    : recipes.filter(el => el.typy.includes(type));
  wrapper.innerHTML = '';

  fittingRecipes.forEach((recipe) => {
    const recipeEl = document.createElement('div');
    recipeEl.classList.add('recipe-item');

    const imageEl = document.createElement('img');
    imageEl.classList.add('recipe-image');
    imageEl.src = recipe.obrazek;

    const titleEl = document.createElement('h6');
    titleEl.classList.add('recipe-title');
    titleEl.innerText = recipe.nazwa;

    const descEl = document.createElement('p');
    descEl.classList.add('recipe-description');
    descEl.innerText = recipe.opis;

    recipeEl.insertAdjacentElement('beforeend', imageEl);
    recipeEl.insertAdjacentElement('beforeend', titleEl);
    recipeEl.insertAdjacentElement('beforeend', descEl);
    wrapper.insertAdjacentElement('beforeend', recipeEl);
  });
};

button.addEventListener('click', (e) => {
  const selectedValue = select.options[select.selectedIndex].value;
  if (selectedValue) {
    drawRecipes(selectedValue);
  }
});

document.addEventListener('DOMContentLoaded', () => {
  fetch('../assets/recipes.json')
    .then(response => response.json())
    .then((data) => {
      recipes = data.przepisy;
      // quickest way to get rid of duplicates
      const allTypes = ['wszystkie', ...new Set(recipes.reduce((acc, el) => ([...acc, ...el.typy]), []))];
      select.innerHTML = '';

      allTypes.forEach((el) => {
        const option = document.createElement('option');
        option.value = el;
        option.innerText = el;
        select.insertAdjacentElement('beforeend', option);
      });

      drawRecipes('wszystkie');
    });
});