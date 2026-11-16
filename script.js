const menuToggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');
menuToggle.addEventListener('click', () => {
  const isOpen = nav.classList.toggle('open');
  menuToggle.setAttribute('aria-expanded', String(isOpen));
});
document.querySelectorAll('.nav-link').forEach(link => link.addEventListener('click', () => {
  nav.classList.remove('open'); menuToggle.setAttribute('aria-expanded', 'false');
}));
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
document.getElementById('year').textContent = new Date().getFullYear();
const form = document.getElementById('contactForm');
form.addEventListener('submit', async event => {
  event.preventDefault();
  const status = document.getElementById('formStatus');
  const button = form.querySelector('button[type="submit"]');
  button.disabled = true; button.textContent = 'Sending…';
  try {
    const response = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json' } });
    const result = await response.json();
    if (!response.ok || !result.success) throw new Error(result.message || 'Message could not be sent.');
    status.textContent = 'Thank you! Your message has been saved successfully.';
    form.reset();
  } catch (error) {
    status.textContent = 'Could not save the message. Please configure PHP/MySQL or email Hemen directly at hemenh29@gimal.com.';
  } finally { button.disabled = false; button.innerHTML = 'Send message <span>↗</span>'; }
});
