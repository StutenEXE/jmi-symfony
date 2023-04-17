let constrainContact = 2;
let contactsLayers = document.getElementsByClassName("contact");

function transforms(x, y, el, constrain) {
    let box = el.getBoundingClientRect();
    let calcX = -(y - box.y - (box.height / 2)) / constrain;
    let calcY = (x - box.x - (box.width / 2)) / constrain;

    return "perspective(100px) "
        + "   rotateX(" + calcX + "deg) "
        + "   rotateY(" + calcY + "deg) ";
};

function transformContact(el, xyEl) {
    el.style.transform = transforms.apply(null, xyEl.concat([constrainContact]));
}

function resets(el) {
    return "perspective(100px) "
        + "   rotateX(" + 0 + "deg) "
        + "   rotateY(" + 0 + "deg) ";
}

function resetElement(el) {
    el.style.transform = resets(el);
}

for(let contactLayer of contactsLayers) {
    contactLayer.onmousemove = function (e) {
        let xy = [e.clientX, e.clientY];
        let position = xy.concat([contactLayer]);

        window.requestAnimationFrame(function () {
            transformContact(contactLayer, position);
        });
    }

    contactLayer.onmouseout = function (e) {
        window.requestAnimationFrame(function () {
            resetElement(contactLayer);
        });
    }
}

// Pour suivi de la souris sur tout l'écran

// let mouseOverContainer = document.body;

// mouseOverContainer.onmousemove = function (e) {
//     for (let contactLayer of contactsLayers) {
//         let xy = [e.clientX, e.clientY];
//         let position = xy.concat([contactLayer]);

//         window.requestAnimationFrame(function () {
//             transformContact(contactLayer, position);
//         });
//     }
// };