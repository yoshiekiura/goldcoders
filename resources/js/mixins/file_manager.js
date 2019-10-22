export default {
    methods: {
        formatManagerFileForCreated(documents) {
            let self = this;
            let images = [];
            let filesAmount = documents.length;
            for (let i = 0; i < filesAmount; i++) {
                let file = self.setFileDisplay(
                    self.getFileExtension(documents[i])
                );
                if (file == "images") {
                    images.push(documents[i]);
                } else {
                    images.push(file);
                }
            }
            return images;
        },

        formatManagerFiles(val) {
            let images = [];
            let self = this;
            if (val) {
                var filesAmount = val.length;
                for (let i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function(event) {
                        let file = self.setFileDisplay(
                            self.getFileExtension(val[i].name)
                        );
                        if (file == "images") {
                            images.push(event.target.result);
                        } else {
                            images.push(file);
                        }
                    };
                    reader.readAsDataURL(val[i]);
                }
                return images;
            }
        },
        getFileExtension(filename) {
            return /[.]/.exec(filename)
                ? /[^.]+$/.exec(filename)[0]
                : undefined;
        },
        setFileDisplay(file) {
            switch (file) {
                // case "jpg", "png", "jpeg":
                //     console.log('picture')
                //   return "images";
                //   break;
                case "jpg":
                    return "images";
                    break;
                case "png":
                    return "images";
                    break;
                case "jpeg":
                    return "images";
                    break;
                case "doc":
                    return this.url + "/images/file_placeholder/doc.png";
                    break;
                case "docx":
                    return this.url + "/images/file_placeholder/docx.png";
                    break;
                case "xls":
                    return this.url + "/images/file_placeholder/xls.png";
                    break;
                case "xlsx":
                    return this.url + "/images/file_placeholder/xlsx.png";
                    break;
                case "pdf":
                    return this.url + "/images/file_placeholder/pdf.png";
                    break;
                default:
                    return this.url + "/images/file_placeholder/file.png";
                    break;
            }
        }
    }
};
