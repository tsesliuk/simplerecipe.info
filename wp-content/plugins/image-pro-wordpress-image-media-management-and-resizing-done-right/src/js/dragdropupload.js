impro.DragDropUpload = function() {
	return {
        onCompleted: function(e, files, filesSucceeded, filesFailed) {},
		onProgress : function(e, file, i, currentFileProgress, totalProgress) {},
        onDropFiles : function(e, files) {},

		url : "",
		mouseOverClass : "vdragover",

		init : function(id, options) {
			this._el = document.getElementById(id);
			this.el = jQuery(this._el);
			this.el.bind("dragover", jQuery.proxy(this._over, this))
                .bind("dragenter", function() { return false; })
                .bind('dragleave', jQuery.proxy(this._leave, this))
                .bind("drop", jQuery.proxy(this._drop, this));

			jQuery.extend(this, options);
		},
		hideHighlight : function() {
			this.el.removeClass(this.mouseOverClass);
		},
		_leave : function(e) {
			return this.hideHighlight();
		},
		_over : function(e) {
			var dt = e.originalEvent.dataTransfer;
			if (!dt
                || (dt.types.contains && !dt.types.contains("Files"))
                || (dt.types.indexOf && dt.types.indexOf("Files") == -1)
            ) {
				return;
            }

            dt.dropEffect = 'copy';

			this.el.addClass(this.mouseOverClass);

			return false;
		},
		_drop : function(e) {
			var dt = e.originalEvent.dataTransfer;
			if (!dt && !dt.files) {
				return;
            }

			this.hideHighlight();

            if ('function' === typeof this.onDropFiles) {
                this.onDropFiles.call(this, e, dt.files);
            }
            this.uploadMultipleFiles(dt.files);

            return false;
		},

        uploadMultipleFiles: function(files) {
            var that = this,
                i = 0,
                filesFailed = [],
                filesSucceeded = [];

            /**
             * uploads a single file and triggers load, error and progress events
             * @param file the File object to upload
             * @param load triggered on success
             * @param error triggered on error
             * @param progress triggered on progress
             */
            var uploadSingleFile = function(file, load, error, progress) {
                var xhr = new XMLHttpRequest();
                /* register progress event */
                xhr.addEventListener("progress", jQuery.proxy(function(e) {
                    if ('function' === typeof progress) {
                        progress.call(this, e, file);
                    }
                }, that), false);
                /* register successful event */
                xhr.addEventListener("load", jQuery.proxy(function(e) {
                    /* increase the number of files processed with 1 */
                    i++;
                    if ('function' === typeof load) {
                        load.call(this, e, file);
                    }
                }, that), false);
                /* register error event */
                xhr.addEventListener("error", jQuery.proxy(function(e) {
                    /* increase the number of files processed with 1 */
                    i++;
                    if ('function' === typeof error) {
                        error.call(this, e, file);
                    }
                }, that), false);
                /* perform upload */
                xhr.open('POST', that.url + "?name=" + file.name, true);
                xhr.send(file);
            };

            /**
             * call the onCompleted function to notify of completion
             * this method will provide the event of the last file
             * and all the files, the files that succeeded and
             * the files that failed
             * @param e
             * @param file
             */
            var finished = function(e, file) {
                if ('function' === typeof that.onCompleted) {
                    that.onCompleted.call(that, e, files, filesSucceeded, filesFailed);
                }
            };

            /**
             * called when a file has been successfully uploaded
             * @param e
             * @param file
             */
            var individualLoad = function(e, file) {
                /* the server returned data, but is it correct? was the file uploaded successfully? */
                var response = e.target.response;
                try {
                    response = JSON.parse(e.target.response);
                } catch(e) {}

                /* if upload was successful */
                if ('object' === typeof response && response['ok'] === true) {
                    filesSucceeded.push(file);
                    if (i === files.length) {
                        finished(e, file);
                    } else {
                        uploadSingleFile(files[i], individualLoad, individualError, individualProgress);
                    }
                } else {
                    individualError(e, file, e.target.status, response);
                }
            };

            /**
             * called when a file has failed uploading (server error, not upload code error)
             * @param e
             * @param file
             * @param httpStatus
             * @param httpResponse
             */
            var individualError = function(e, file, httpStatus, httpResponse) {
                filesFailed.push(file);
                filesFailed[filesFailed.length - 1].httpStatus = httpStatus;
                filesFailed[filesFailed.length - 1].httpResponse = httpResponse;
                if (i === files.length) {
                    finished(e, file);
                } else {
                    uploadSingleFile(files[i], individualLoad, individualError, individualProgress);
                }
            };

            /**
             * called when a progress event occurs for a file
             * @param e
             * @param file
             */
            var individualProgress = function(e, file) {
                if ('function' === typeof that.onProgress) {
                    var currentFileProgress = Math.round((e.loaded / e.total) * 100);
                    /* sometimes, e.total is zero, so we get infinite */
                    if (!isFinite(currentFileProgress)) {
                        /* though we may not get a new progress event, we set it to 3% falsy,
                        so at least a small part of the progress is visible */
                        currentFileProgress = 5;
                    }
                    var totalProgress = Math.round((i / files.length) * 100) + Math.round(currentFileProgress * (1 / files.length));
                    that.onProgress(e, file, i, currentFileProgress, totalProgress);
                }
            };

            /* start uploading the first file */
            uploadSingleFile(files[i], individualLoad, individualError, individualProgress);
        }
	};
};