import "emoji-picker-element";

document.addEventListener("DOMContentLoaded", function () {
    const emojiPicker = document.createElement("emoji-picker");

    // Define o locale para português
    emojiPicker.locale = "pt";

    // Sobrescreve as strings padrão com traduções para o português,
    // incluindo as propriedades que estavam faltando (skinToneLabel e skinTones)
    emojiPicker.i18n = {
        search: "Pesquisar",
        categories: {
            recents: "Recentes",
            smileys: "Emoticons",
            people: "Pessoas",
            nature: "Natureza",
            foods: "Comidas",
            activity: "Atividades",
            places: "Lugares",
            objects: "Objetos",
            symbols: "Símbolos",
            flags: "Bandeiras",
            custom: "Personalizados"
        },
        notFound: "Emoji não encontrado",
        skinTonePicker: "Seletor de tom de pele",
        skinToneLabel: "Selecione um tom de pele",
        skinTones: ["Padrão", "Claro", "Médio-claro", "Médio", "Médio-escuro", "Escuro"]
    };

    emojiPicker.classList.add(
        "hidden",
        "absolute",
        "bottom-16",
        "left-0",
        "z-50"
    );

    document.body.appendChild(emojiPicker);

    // Função para remover todos os atributos "title" do shadow DOM do emojiPicker
    function removeTitlesFromEmojiPicker() {
        if (emojiPicker.shadowRoot) {
            const emojiItems = emojiPicker.shadowRoot.querySelectorAll('[title]');
            emojiItems.forEach(item => {
                item.removeAttribute('title');
            });
        }
    }

    // Função para remover o elemento "search-wrapper" do shadow DOM
    function removeSearchWrapper() {
        if (emojiPicker.shadowRoot) {
            const searchWrapper = emojiPicker.shadowRoot.querySelector(".search-wrapper");
            if (searchWrapper) {
                searchWrapper.remove();
                // searchWrapper.style.display = "none";
            }
        }
    }

    function colorPicker(){
        if (emojiPicker.shadowRoot) {
            const colorPicker = emojiPicker.shadowRoot.querySelector(".picker");
            const pad_top = emojiPicker.shadowRoot.querySelector(".pad-top");
            const skintone = emojiPicker.shadowRoot.querySelector(".search-row");
            const emojiMenu = emojiPicker.shadowRoot.querySelector(".emoji-menu");
            if (colorPicker) {
                colorPicker.style.cssText = "background-color: #bdc1ca; border-radius: 0.5rem; padding: 0.5rem; margin: 0.5rem; ";
            }
            if(pad_top){
                pad_top.remove();
            }
            if(skintone){
                skintone.remove();
            }
            if(emojiMenu){
                emojiMenu.style.cssText = "padding-top: 0.5rem; padding-bottom: 0.5rem;";
            }
        }
    }
    function adjustSearchRow() {
        if (emojiPicker.shadowRoot) {
            const searchRow = emojiPicker.shadowRoot.querySelector(".search-row");
            if (searchRow) {
                searchRow.style.justifyContent = "end";
            }
        }
    }
    
    // Configura um MutationObserver para executar as funções sempre que o conteúdo do shadow DOM mudar
    function setupObserver() {
        if (emojiPicker.shadowRoot) {
            const observer = new MutationObserver((mutationsList) => {
                mutationsList.forEach(mutation => {
                    if (mutation.type === "childList") {
                        removeTitlesFromEmojiPicker();
                        removeSearchWrapper();
                        adjustSearchRow();
                        colorPicker();
                    }
                });
            });
            observer.observe(emojiPicker.shadowRoot, { childList: true, subtree: true });
        }
    }

    // Tenta configurar o observer imediatamente ou aguarda se o shadowRoot ainda não estiver disponível
    if (emojiPicker.shadowRoot) {
        setupObserver();
    } else {
        setTimeout(setupObserver, 500);
    }

    const emojiButton = document.getElementById("emoji-button");
    const chatInput = document.getElementById("chat-input");
    let isPickerOpen = false;

    if (emojiButton) { 
    emojiButton.addEventListener("click", function (event) {
        event.preventDefault();

        if (isPickerOpen) {
            emojiPicker.classList.add("hidden");
            isPickerOpen = false;
        } else {
            const rect = emojiButton.getBoundingClientRect();
            emojiPicker.style.left = `${rect.left -330}px`;
            emojiPicker.style.top = `${rect.top - 410}px`; // Ajuste para aparecer acima do botão
            emojiPicker.classList.remove("hidden");
            isPickerOpen = true;

            // Após exibir o picker, remove os titles e oculta o search-wrapper
            setTimeout(() => {
                removeTitlesFromEmojiPicker();
                removeSearchWrapper();
                adjustSearchRow();
                colorPicker();
            }, 200);
        }
    });
    }
    emojiPicker.addEventListener("emoji-click", (event) => {
        chatInput.value += event.detail.unicode;
        chatInput.dispatchEvent(new Event("input")); 
    });

    document.addEventListener("click", function (event) {
        if (!emojiPicker.contains(event.target) && event.target !== emojiButton) {
            emojiPicker.classList.add("hidden");
            isPickerOpen = false;
        }
    });
});
