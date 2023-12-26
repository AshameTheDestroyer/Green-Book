const elementsToBePortaled = [...document.querySelectorAll("[data-create-portal]")];
elementsToBePortaled.forEach(element => {
    const
        destinationElement = document.querySelector(`${element.dataset["createPortal"]}`),
        portalIndex = element.dataset["portalIndex"];

    element.removeAttribute("data-create-portal");
    element.removeAttribute("data-portal-index");

    if (portalIndex == null) {
        destinationElement.append(element);
        return;
    }

    destinationElement.insertBefore(element, destinationElement.children[portalIndex]);
});