// const info1 = document.getElementsByClassName("info1");
// const deskripsi = document.getElementsByClassName('deskripsi');

function toggleDropdown1() {
  const deskripsi = document.getElementById('deskripsi1');
  deskripsi.classList.toggle('show1');
}

function toggleDropdown2() {
  const deskripsi = document.getElementById('deskripsi2');
  deskripsi.classList.toggle('show2');
}

function toggleDropdown3() {
  const deskripsi = document.getElementById('deskripsi3');
  deskripsi.classList.toggle('show3');
}

function tambahData() {
  window.location = 'fill_form.php';
}

const cartIcon = document.getElementById('cartIcon');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const closeSidebar = document.querySelector('.icon_exit span');

cartIcon.addEventListener('click', () => {
    sidebar.classList.add('show-sidebar');
    overlay.classList.add('show-overlay');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('show-sidebar');
    overlay.classList.remove('show-overlay');
});

closeSidebar.addEventListener('click', () => {
    sidebar.classList.remove('show-sidebar');
    overlay.classList.remove('show-overlay');
});
// // Close the dropdown if the user clicks outside of it
// window.addEventListener('click', (event) => {
//   const servicesDropdown = document.getElementById('servicesDropdown');
//   if (!event.target.matches('button') && servicesDropdown.classList.contains('show')) {
//     servicesDropdown.classList.remove('show');
//   }
// });
