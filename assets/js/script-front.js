function laPortFullSlideShow($this, side) {
  $this.setAttribute("disabled", true);
  const imgs = Array.from(
    $this
      .closest(".la-port-fulls-carousel-content")
      .querySelectorAll(".img-show")
  );
  const indicadores = Array.from(
    $this
      .closest(".la-port-fulls-carousel-content")
      .parentNode.querySelectorAll(".la-indicators-content-item")
  );
  var min = -100;
  var max = 100 * (imgs.length - 2);

  indicadores.forEach(function (ind) {
    ind.classList.remove("active");
  });

  imgs.forEach(function (elem, index) {
    var posX = parseInt(elem.style.left);
    posX += side == "next" ? 100 : -100;
    elem.style.left = posX + "%";
    elem.style.transitionDuration = "0.1s";

    if (posX == 0 && indicadores[index]) {
      indicadores[index].classList.add("active");
    }

    elem.addEventListener("transitionend", function (e) {
      if (posX < min || max < posX) {
        posX = posX <= min ? max : -100;
        e.target.style.left = posX + "%";
        e.target.style.transitionDuration = "0s";
        $this.removeAttribute("disabled");
      } else {
      }
    });
  });
}

function laFullsShowJob(post, type) {
  const formData = new FormData();
  formData.append("action", "la_port_fulls_ajax");
  formData.append("nonce", la_ajax.nonce);
  formData.append("post", post);
  formData.append("type", type);

  let requestData = {
    action: "la_port_fulls_ajax",
    nonce: la_ajax.nonce,
    post: post,
    type: type,
  };

  fetch(la_ajax.url, {
    method: "post",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams(requestData).toString(),
    // body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.success) {
        document
          .querySelector("body")
          .append(laPortRenderDetail(response.data));
      } else {
        alert("Erro: " + response.data);
      }
    })
    .catch((error) => console.error("Erro:", error));
}

function laPortFullModalShowImg($this) {
  var section = $this.closest(".la-port-fulls-modal");
  var destaque = section.querySelector(".la-port-full-img-destaque");
  var img = destaque.querySelector("img");
  var href = destaque.querySelector("a");
  img.src = $this.src;
  href.href = $this.src;
}

function laPortRenderDetail(htmlString) {
  var div = document.createElement("div");
  div.innerHTML = htmlString.trim();

  // Change this to div.childNodes to support multiple top-level nodes.
  return div.firstChild;
}
