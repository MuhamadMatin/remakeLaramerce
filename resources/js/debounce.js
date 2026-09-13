function debounce(fn, delay) {
  let timeOut = null;
  return function () {
    clearTimeout(timeOut);
    var args = arguments;
    var that = this;
    timeOut = setTimeout(() => {
      fn.apply(that, args);
    }, delay);
  };
}

export default debounce;
