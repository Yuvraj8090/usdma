// Live Date Update
function updateDateTime() {
  const now = new Date();
  document.getElementById("wxDate").innerText =
    now.toLocaleDateString("en-IN", { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}
setInterval(updateDateTime, 1000);
updateDateTime();

// Animate Temperature Counter
function animateValue(id, start, end, duration) {
  let obj = document.getElementById(id);
  let range = end - start;
  let stepTime = Math.abs(Math.floor(duration / range));
  let startTime = new Date().getTime();
  let endTime = startTime + duration;
  let timer = setInterval(function() {
    let now = new Date().getTime();
    let remaining = Math.max((endTime - now) / duration, 0);
    let value = Math.round(end - (remaining * range));
    obj.innerHTML = value;
    if (value == end) {
      clearInterval(timer);
    }
  }, stepTime);
}

// Example: Animate temp from 0 → 21
animateValue("wxTemp", 0, 21, 2000);

 // Date helpers
    const d = new Date();
    const options = { weekday:'short', day:'2-digit', month:'short', year:'numeric' };
    document.getElementById('today').textContent = d.toLocaleDateString('en-GB', options);
    document.getElementById('wxDate').textContent = d.toLocaleDateString('en-GB', options);
    document.getElementById('lastUpdated').textContent = d.toLocaleString();
    document.getElementById('year').textContent = d.getFullYear();

    // Back-to-top
    const backTop = document.querySelector('.back-to-top');
    window.addEventListener('scroll', () => {
      backTop.style.display = window.scrollY > 400 ? 'inline-flex' : 'none';
    });

 
    document.querySelectorAll('.navbar .dropdown').forEach(function (dropdown) {
  dropdown.addEventListener('mouseover', function () {
    this.querySelector('.dropdown-menu').classList.add('show');
  });
  dropdown.addEventListener('mouseout', function () {
    this.querySelector('.dropdown-menu').classList.remove('show');
  });
});
