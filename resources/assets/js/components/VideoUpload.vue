<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div id="video-form" v-if="uploading">
                            
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <button class="btn btn-outline-secondary" type="submit" @click.prevent="update">Save Changes</button>
                            <span class="text-gray-dark">{{ saveStatus }}</span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                uid: null,
                uploading: false,
                uploadingComplete: false,
                falied: false,
                title: 'Untitle',
                description: null,
                visibility: 'private',
                saveStatus: null
            }
        },
        methods: {
            store() {
                axios.post('/videos', {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                })
                    .then(response => this.uid = response.data.uid)
                    .catch(error => console.log(error))
            },
            fileInputChange() {
                this.uploading = true;
                this.falied = false;

                this.file = document.getElementById('video').files[0];

                this.store();
                
            },
            update() {
                this.saveStatus = 'Saving Changes';
                
                axios.put('/videos/'+this.uid, {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                })
                    .then(response => {
                        this.saveStatus = 'Changed Saved.';

                        setTimeout(() => {
                            this.saveStatus = null;
                        }, 3000)
                    })
                    .catch(error => {
                        console.log(error)
                        this.saveStatus = 'Failed to save changes.';
                    })
            },
        },
        mounted() {
            //
        }
    }
</script>
