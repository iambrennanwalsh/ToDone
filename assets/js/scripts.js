/**
 * @name:          scripts.js
 * @description:   Helper functions, and general js scripts.
 */

/**
 * @method: scripts.animate()
 *
 * Adds an animate.css class to an element on page load,
 * and removed the class when it finishes.
 */
export function animate(element, animationName, callback) {
  const nodes = document.querySelectorAll(element);

  nodes.forEach(node => {
    node.classList.add("animated", animationName);
    node.addEventListener("animationend", handleAnimationEnd);
  });

  function handleAnimationEnd(node) {
    node.classList.remove("animated", animationName);
    node.removeEventListener("animationend", handleAnimationEnd);
    if (typeof callback === "function") callback();
  }
}