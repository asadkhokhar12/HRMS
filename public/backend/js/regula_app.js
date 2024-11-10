const component = document.getElementsByTagName('face-capture')[0];


function listener(event) {
    if (event.detail.action === 'PROCESS_FINISHED' && event.detail.data.status === 1) {
        // const response = event.detail.data.response.capture;
        // // console.log(response);
        // axios.post('http://hrm.test/api/V11/test/face', {
        //     response: response[0]
        // })
        // .then(function (response) {
        //     console.log('Response sent successfully:', response.data);
        // })
        // .catch(function (error) {
        //     console.error('Error sending response:', error);
        // });
    }
}

component.addEventListener('face-capture', (event) => {
    let action = event.detail.action;
    if (action === 'PROCESS_FINISHED' && event.detail.data.status === 1) {
        const response = event.detail.data.response.capture;
        axios.post("{{route('api.testFace')}}", {
            response: response
        })
        .then(function (response) {
            console.log('Response sent successfully:', response.data);
        })
        .catch(function (error) {
            console.error('Error sending response:', error);
        });
    }
}); 

component.settings = {
    locale: 'en',
    copyright: true,

    changeCamera: true,
    startScreen: true,
    closeDisabled: true,
    finishScreen: true,
    videoRecording: true,
    url: 'hrm.test/api/V11/test/face',
    headers: {
        Authorization: 'Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ=='
    },
    tag: 'sessionIdValue',
    retryCount: 5,
    customization: {
        fontFamily: 'Noto Sans, sans-serif',
        fontSize: '16px',
        onboardingScreenStartButtonBackground: '#7E57C5',
        onboardingScreenStartButtonBackgroundHover: '#7c45b4',
        onboardingScreenStartButtonTitle: '#FFFFFF',
        onboardingScreenStartButtonTitleHover: '#FFFFFF',
        cameraScreenFrontHintLabelBackground: '#E8E8E8',
        onboardingScreenIllumination: 'https://t4.ftcdn.net/jpg/02/45/56/35/360_F_245563558_XH9Pe5LJI2kr7VQuzQKAjAbz9PAyejG1.jpg',
        onboardingScreenAccessories: 'data:image/png;base64,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',
        onboardingScreenCameraLevel: "",
        cameraScreenFrontHintLabelText: '#000000',
        cameraScreenSectorActive: '#7E57C5',
        cameraScreenSectorTarget: '#BEABE2',
        cameraScreenStrokeNormal: '#7E57C5',
        processingScreenProgress: '#7E57C5',
        retryScreenRetryButtonBackground: '#7E57C5',
        retryScreenRetryButtonBackgroundHover: '#7c45b4',
        retryScreenRetryButtonTitle: '#FFFFFF',
        retryScreenRetryButtonTitleHover: '#FFFFFF',
        retryScreenEnvironmentImage: 'https://static.thenounproject.com/png/1921258-200.png',
        retryScreenPersonImage: 'https://t4.ftcdn.net/jpg/04/75/01/73/360_F_475017388_FrmbYx5rSNbDC20QYuUVeHchl2uTsceG.jpg',
        successScreenImage: "https://w7.pngwing.com/pngs/367/284/png-transparent-correct-success-tick-basic-ui-elements-icon.png",
    }
}