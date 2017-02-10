
// ---------------------------------------------------------------------------------------------

(function () {

    var xhr = new XMLHttpRequest();
    xhr.open('get', '/banners/ajax', true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var banners = JSON.parse(xhr.responseText);
            var bAjax = document.querySelector('.b-ajax');
            banners.forEach(function (item, index) {
                console.log(item);
            });
        }
    }

})();

// ---------------------------------------------------------------------------------------------

(function () {
    var bannerFileFieldset = document.querySelector('.js-banner-file'),
        bannerTitleFieldset = document.querySelector('.js-banner-title'),
        bannerPathsFieldset = document.querySelector('.js-banner-paths'),
        bannerFileInput = document.querySelector('.js-banner-file-input'),
        bannerFileStatus = document.querySelector('.js-banner-file-status'),
        bannerProjectInput = document.querySelector('.js-banner-project-input'),
        bannerTypeInput = document.querySelector('.js-banner-type-input'),
        bannerWidthInput = document.querySelector('.js-banner-width-input'),
        bannerHeightInput = document.querySelector('.js-banner-height-input'),
        bannerTitleInput = document.querySelector('.js-banner-title-input'),
        bannerDirInput = document.querySelector('.js-banner-dir-input'),
        bannerUrlsWrapper = document.querySelector('.js-banner-urls'),
        bannerUrlInput,
        bannerThumbUrlInput = document.querySelector('.js-banner-thumb-url-input');

    if (bannerFileInput) {

        bannerFileInput.addEventListener('change', BFI_changeHandler, false);
        bannerFileInput.addEventListener('click', BFI_clickHandler, false);
        bannerProjectInput.addEventListener('input', BPI_changeHandler, false);

        function BPI_changeHandler(event) {
            if (event.target.value) {
                if (bannerFileFieldset.disabled === true) {
                    bannerFileFieldset.disabled = false;
                    bannerFileFieldset.classList.add('fieldset_is_active');
                }
            } else {
                bannerFileFieldset.disabled = true;
                bannerFileFieldset.classList.remove('fieldset_is_active');
            }
        }

        function BFI_changeHandler(event) {

            var xhr = new XMLHttpRequest(),
                formData = new FormData(),
                data,
                urls;

            formData.append('ajax', 1);
            formData.append('banner_project', bannerProjectInput.value);
            formData.append('banner_type', bannerTypeInput.value);
            formData.append('banner_width', bannerWidthInput.value);
            formData.append('banner_height', bannerHeightInput.value);
            formData.append('banner_file', event.target.files[0]);

            xhr.open('post', '/admin/banners/post-upload');

            xhr.upload.onprogress = function (event) {
                //console.log(event);
            };

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        try {
                            console.log(xhr.responseText);
                            data = JSON.parse(xhr.responseText);
                        } catch (error) {
                            console.log(error);
                        }

                        console.log(data);
                        if (data.errors.length === 0) {
                            urls = data.http.urls.banners;
                            // remove urls fields before creating new
                            bannerUrlsWrapper.innerHTML = '';

                            for (var i = 0; i < urls.length; i++) {
                                bannerUrlInput = document.createElement('input');
                                bannerUrlInput.setAttribute('type', 'text');
                                bannerUrlInput.setAttribute('name', 'banner_url[]');
                                bannerUrlInput.className = 'form-control form__input form__input_type_url';
                                bannerUrlInput.value = data.http.urls.banners[i];
                                bannerUrlsWrapper.appendChild(bannerUrlInput);
                            }

                            bannerDirInput.value = data.local['banner_directory'];
                            bannerThumbUrlInput.value = data.http.urls.thumbs[0];
                            bannerTitleInput.value = data['title'];
                            bannerFileFieldset.classList.remove('fieldset_is_error');
                            bannerFileFieldset.classList.remove('fieldset_is_active');
                            bannerFileFieldset.classList.add('fieldset_is_success');
                            bannerFileStatus.classList.remove('form__block_is_hidden');
                            bannerFileStatus.innerHTML = data.message;
                            bannerTitleFieldset.disabled = false;
                            bannerPathsFieldset.disabled = false;
                        } else {
                            bannerFileFieldset.classList.remove('fieldset_is_success');
                            bannerFileFieldset.classList.remove('fieldset_is_active');
                            bannerFileFieldset.classList.add('fieldset_is_error');
                            bannerFileStatus.classList.remove('form__block_is_hidden');
                            data.errors.forEach(function (item) {
                                bannerFileStatus.innerHTML += item + '<br>';
                            });
                            bannerFileInput.value = '';
                        }
                    }
                }
            };

            xhr.send(formData);
        }

        function BFI_clickHandler(event) {
            event.target.value = null;
            bannerFileStatus.innerHTML = '';
        }
    }

})();

// ---------------------------------------------------------------------------------------------

(function () {
    var clearEmptyProjects = document.querySelector('.js-make-clean');

    if (clearEmptyProjects) {
        clearEmptyProjects.addEventListener('click', CEP_clickHandler, false);

        function CEP_clickHandler(event) {
            event.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open('post', '/admin/cleaner.php');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                    }
                }
            };
            xhr.send(null);
        }
    }

})();