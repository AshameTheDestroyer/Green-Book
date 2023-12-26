const
    modals = [...document.querySelectorAll(".modal")],
    modalBackgrounds = [...document.querySelectorAll(".modal-background")],
    modalContainer = document.querySelector("#modal-container");

SetUpModals();
SetUpModalBackgrounds();

function SetUpModals() {
    modals.forEach(modal => {
        modalContainer.appendChild(modal);

        const
            modalId = modal.id,
            modalBackgroundId = modalId.replace("modal", "modal-background"),
            modalBackground = document.querySelector(`#${modalBackgroundId}`);

        modal.querySelector(".modal-close-button-container>button")
            .addEventListener("click", _e => CloseModal(modal, modalBackground));
    });
}

function SetUpModalBackgrounds() {
    modalBackgrounds.forEach(modalBackground => {
        modalContainer.appendChild(modalBackground);

        const
            modalBackgroundId = modalBackground.id,
            modalId = modalBackgroundId.replace("modal-background", "modal"),
            modal = document.querySelector(`#${modalId}`);

        modalBackground.addEventListener("click", _e => CloseModal(modal, modalBackground));
    });
}

function CloseModal(modal, modalBackground) {
    modal.classList.add("modal-hidden");
    modalBackground.classList.add("modal-background-hidden");
}