class DarkModeToggle{
    constructor(){
        //button to toggle
        this.darkModeToggleBtn = document.querySelector('#darkModeToggleBtn');

        //all hr lines
        this.hrTags = document.getElementsByTagName('hr');

        //login modal
        this.loginModalBG = document.querySelector('.modal-content');

        this.ToggleDarkmode();
        this.LoadCheckDarkmode();
        this.LoadDarkmodeBtnText();
        this.ToggleDarkmodeBtnText();        
    }

 

    //add or remove item from localstorage to toggle darkmode class
    ToggleDarkmode(){
        this.darkModeToggleBtn.addEventListener('click', () => {
            if(localStorage.getItem('darkMode') == '1'){
                localStorage.removeItem('darkMode');
                document.body.classList.remove('darkmode-bg');

                //toggle hr lines to be light during darkmode
                let i;
                for(i = 0; i < this.hrTags.length; i++){
                    this.hrTags[i].classList.remove('border-light');
                }

                this.loginModalBG.classList.remove('darkmode-bg');
            } else {
                localStorage.setItem('darkMode', '1');
                document.body.classList.add('darkmode-bg');

                let i;
                for(i = 0; i < this.hrTags.length; i++){
                    this.hrTags[i].classList.add('border-light');
                }

                this.loginModalBG.classList.add('darkmode-bg');
            }
        })
    }

    //enable darkmode on page load if its set
    LoadCheckDarkmode(){
        window.addEventListener('load', () => {
            if(localStorage.getItem('darkMode') == '1'){
                document.body.classList.add('darkmode-bg');
                
                let i;
                for(i = 0; i < this.hrTags.length; i++){
                    this.hrTags[i].classList.add('border-light');
                }

                this.loginModalBG.classList.add('darkmode-bg');
            }
        })
    }

    //insert text into the button on page load depending on whats its set to in the localstorage
    LoadDarkmodeBtnText(){
        window.addEventListener('load', () => {
            if(localStorage.getItem('darkMode') == 1){
                darkModeToggleBtn.innerHTML = 'Lightmode';
            } else {
                darkModeToggleBtn.innerHTML = 'Darkmode';
            }
        })
    }

    //toggle text on the button
    ToggleDarkmodeBtnText(){
        this.darkModeToggleBtn.addEventListener('click', () => {
            if(darkModeToggleBtn.innerHTML == 'Darkmode'){
                darkModeToggleBtn.innerHTML = 'Lightmode';
            } else {
                darkModeToggleBtn.innerHTML = 'Darkmode';
            }
        })
    }
}

export default DarkModeToggle;