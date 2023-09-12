const hamburger = document.querySelector('.hamburger');
const menu = document.querySelector('.menu');
const header = document.querySelector('header');
const menuul = document.querySelector('.menu ul');
const img = document.querySelector('.logo');
const arrow = document.querySelector('#arrow');

hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('active');
  menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  menu.style.display === 'block' ? menu.style.opacity = '1' : menu.style.opacity = '0';
  header.style.height = header.style.height === '100vh' ? 'auto' : '100vh';
  menu.style.height = menu.style.height === '100vh' ? 'auto' : '100vh';
  menu.style.flexDirection = menu.style.flexDirection === 'column' ? 'row' : 'column';
  menuul.style.flexDirection = menuul.style.flexDirection === 'column' ? 'row' : 'column';
  menuul.style.justifyContent = menuul.style.justifyContent === 'center' ? 'space-between' : 'center';
  menu.style.marginTop = menu.style.marginTop === '2em' ? '0' : '2em';
  menu.style.margin= menu.style.margin === '15em' ? '0 0 0 2em' : '15em';
  img.style.justifyContent = img.style.justifyContent === 'center' ? 'flex-start' : 'center';
  img.style.display = img.style.display === 'flex' ? 'none' : 'flex';
  img.style.width = img.style.width === '50%' ? 'auto' : '50%';
  img.style.height = img.style.height === 'auto' ? '6em' : 'auto';
  header.style.flexDirection = header.style.flexDirection === 'column' ? 'row' : 'column';
  arrow.style.display = arrow.style.display === 'none' ? 'block' : 'none';
  hamburger.style.display = hamburger.style.display === 'absolute' ? 'block' : 'absolute';
  hamburger.style.top = hamburger.style.top === '0' ? '2em' : '0';
    hamburger.style.right = hamburger.style.right === '0' ? '2em' : '0';


});