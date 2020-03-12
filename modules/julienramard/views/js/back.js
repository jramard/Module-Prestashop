document.addEventListener('DOMContentLoaded', () => {
    const toggleMainOptions = document.querySelector(`[data-ref="toggleMainOptions"]`);
    const toggleAdditionalOptions = document.querySelector(`[data-ref="toggleAdditionalOptions"]`);
    const mainOptions = document.querySelector(`[data-ref="mainOptions"]`);
    const additionalOptions = document.querySelector(`[data-ref="additionalOptions"]`);

    toggleMainOptions.addEventListener('click', () => {
        if (!mainOptions.classList.contains('active')) {
            mainOptions.classList.add('active');
            toggleMainOptions.classList.add('active');
            additionalOptions.classList.remove('active');
            toggleAdditionalOptions.classList.remove('active');
        }
    });

    toggleAdditionalOptions.addEventListener('click', () => {
        if (!additionalOptions.classList.contains('active')) {
            additionalOptions.classList.add('active');
            toggleAdditionalOptions.classList.add('active');
            mainOptions.classList.remove('active');
            toggleMainOptions.classList.remove('active');
        }
    });
});
