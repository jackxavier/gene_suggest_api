@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p>
                    To use this UI application you can use two input controls
                    (to search by name (<b>design_label</b> field) and to search by species(<b>species</b> field)).
                    In order to discard search parameters you can click on the cancel button.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="query"
                               placeholder="Search gene by name"
                               v-model="nameBox">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="species"
                               placeholder="Search gene by species"
                               v-model="speciesBox">
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success" @click.prevent="getGenes">
                            Search
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-danger" @click.prevent="onCancel"
                                v-if="onSearch == true">Cancel
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <gene_list :results="results"></gene_list>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Vue.component('gene_list', {
            props: ['results'],
            template: `<table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Name (Label)</th>
                            <th scope="col">Species</th>
                            <th scope="col">Location</th>
                        </tr>
                    </thead>
                    <tbody v-for="geneSuggestion in processedGenes">
                            <tr>
                                <td>@{{ geneSuggestion.display_label }}</td>
                                <td>@{{ geneSuggestion.species }}</td>
                                <td>@{{ geneSuggestion.location }}</td>
                            </tr>
                    </tbody>
                </table>`,
            computed: {
                processedGenes(){
                    return this.results;
                }
            }
        });

        const app = new Vue({
            el: '#app',
            data: {
                onSearch: false,
                nameBox: '',
                speciesBox: '',
                results: {}
            },
            mounted() {
                this.results = {};
                this.getGenes();
            },
            methods: {
                getGenes(){
                    let searchParams = {};
                    if (this.nameBox.length > 0) {
                        searchParams.query = this.nameBox;
                    }
                    if (this.speciesBox.length > 0) {
                        searchParams.species = this.speciesBox
                    }

                    this.onSearch = Object.keys(searchParams).length > 0;

                    axios.get('/api/gene_suggest', {params: searchParams})
                        .then((response) => {
                            this.results = response.data.data.data;
                        }).catch(function (error) {
                        console.log(error)
                    })
                },
                onCancel(){
                    this.nameBox = '';
                    this.speciesBox = '';
                    this.onSearch = false;
                    this.getGenes();
                }
            }
        });
    </script>
@endsection