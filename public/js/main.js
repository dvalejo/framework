
// ---------------------------------------------------------------------------------------------

(function () {
    var bannerFileFieldset = document.querySelector('.js-banner-file'),
        bannerFileInput = document.querySelector('.js-banner-file-input'),
        uploadProgressStatus = document.querySelector('.js-upload-progress-status'),
        uploadProgressResult = document.querySelector('.js-upload-progress-result'),
        bannerErrors = document.querySelector('.js-banner-errors'),
        bannerPathsFieldset = document.querySelector('.js-banner-paths'),
        bannerProjectInput = document.querySelector('.js-banner-project-input'),
        bannerTypeInput = document.querySelector('.js-banner-type-input'),
        bannerWidthInput = document.querySelector('.js-banner-width-input'),
        bannerHeightInput = document.querySelector('.js-banner-height-input'),
        bannerTitleInput = document.querySelector('.js-banner-title-input'),
        bannerDirectoryInput = document.querySelector('.js-banner-directory-input'),
        bannerUrlsWrapper = document.querySelector('.js-banner-urls'),
        bannerUrlInput,
        bannerUrlsFragment,
        bannerThumbUrlInput = document.querySelector('.js-banner-thumb-url-input'),
        timer;

    if (bannerFileInput) {
        bannerFileInput.setAttribute('disabled', 'disabled');
        bannerFileInput.addEventListener('change', bannerFileInput_changeHandler, false);
        bannerFileInput.addEventListener('click', bannerFileInput_clickHandler, false);

        timer = setInterval(function () {
            if (bannerProjectInput.value && bannerTypeInput.value && bannerWidthInput.value && bannerHeightInput.value) {
                bannerFileInput.removeAttribute('disabled');
                clearInterval(timer);
            } else {
                bannerFileInput.setAttribute('disabled', 'disabled');
            }
        }, 1000);

        function bannerFileInput_changeHandler(event) {
            var xhr,
                formData,
                data,
                urls;

            formData = new FormData();
            formData.append('banner_project', bannerProjectInput.value);
            formData.append('banner_type', bannerTypeInput.value);
            formData.append('banner_width', bannerWidthInput.value);
            formData.append('banner_height', bannerHeightInput.value);
            // Если есть input:banner_directory, значит сейчас происходит редактирование баннера
            if (bannerDirectoryInput) {
                formData.append('banner_directory', bannerDirectoryInput.value);
                // Даём знать контроллеру что сейчас происходит редактирование
                formData.append('banner_edit', 1);
            }
            formData.append('banner_file', event.target.files[0]);

            xhr = new XMLHttpRequest();
            xhr.open('post', '/admin/banners/ajax-post-upload');

            xhr.upload.onprogress = function (event) {
                if (event.lengthComputable) {
                    uploadProgressStatus.innerHTML = 'Загружено <b>' + event.loaded + '</b> из <b>' + event.total + '</b> байт.';
                }
            };
            xhr.upload.onload = function (event) {
                bannerFileFieldset.classList.add('fieldset_is_success');
                uploadProgressResult.classList.add('upload-progress__result_is_success');
                uploadProgressResult.innerHTML = 'Файл успешно загружен!';
            };
            xhr.upload.onerror = function (event) {
                bannerFileFieldset.classList.add('fieldset_is_error');
                uploadProgressResult.classList.add('upload-progress__result_is_error');
                uploadProgressResult.innerHTML = 'Извините произошла ошибка!';
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

                        if ( data.errors.length === 0 ) {
                            bannerTitleInput.setAttribute('value', data['title']);
                            bannerThumbUrlInput.setAttribute('value', data.urls.thumbs[0]);
                            bannerUrlsWrapper.innerHTML = '';
                            bannerUrlsFragment = document.createDocumentFragment();
                            data.urls.banners.forEach(function (item) {
                                bannerUrlInput = HTML.create({
                                    'element': 'input',
                                    'attributes': {
                                        'type': 'text',
                                        'name': 'banner_url[]',
                                        'value': item,
                                        'readonly': 'readonly'
                                    },
                                    'class': 'form-control form__input_type_url js-banner-url-input'
                                });
                                bannerUrlsFragment.appendChild(bannerUrlInput);
                            });
                            bannerUrlsWrapper.appendChild(bannerUrlsFragment);
                        } else {
                            bannerErrors.classList.remove('banner-errors_is_hidden');
                            bannerErrors.innerHTML = data.errors;
                        }
                    }
                }
            };
            xhr.send(formData);
        }

        function bannerFileInput_clickHandler(event) {
            event.target.value = null;
            bannerFileFieldset.className = 'fieldset fieldset_type_banner-file js-banner-file';
            uploadProgressResult.innerHTML = '';
            uploadProgressStatus.innerHTML = 'Готов загружать!';
            bannerErrors.classList.add('banner-errors_is_hidden');
        }
    }
})();