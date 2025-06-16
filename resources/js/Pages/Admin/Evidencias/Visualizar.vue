<script setup>
import { useApp } from "@/composables/useApp";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { useAxios } from "@/composables/axios/useAxios";
import { ref, onMounted, onBeforeUnmount } from "vue";
const props = defineProps({});
const { props: props_page } = usePage();
const { setLoading } = useApp();

const cargarControlIntegridad = () => {};

const evidencia_id = ref("");
const oEvidencia = ref(null);
const listEvidencias = ref([]);

const cargarListas = () => {
    cargarEvidencias();
};

const cargarEvidencias = async () => {
    axios.get(route("evidencias.listado")).then((response) => {
        listEvidencias.value = response.data.evidencias;
    });
};

const cargarEvidencia = () => {
    oEvidencia.value = null;
    if (evidencia_id.value) {
        axios
            .get(route("evidencias.show", evidencia_id.value))
            .then((response) => {
                oEvidencia.value = response.data;
            });
    }
};

onMounted(() => {
    cargarListas();
    setTimeout(() => {
        setLoading(false);
    }, 300);
});
onBeforeUnmount(() => {});
</script>
<template>
    <Head title="Notificacions"></Head>

    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Inicio</a></li>
        <li class="breadcrumb-item active">Visualizar Evidencias</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">Visualizar Evidencias</h1>
    <!-- END page-header -->

    <div class="row">
        <div class="col-md-4 mb-2">
            <label>Seleccionar Evidencia*</label>
            <el-select
                v-model="evidencia_id"
                placeholder="- Seleccionar código de evidencia -"
                no-match-text="Sin datos"
                filterable
                @change="cargarEvidencia"
            >
                <el-option
                    v-for="item in listEvidencias"
                    :key="item.id"
                    :value="item.id"
                    :label="item.codigo"
                ></el-option>
            </el-select>
        </div>
        <div class="col-md-12">
            <!-- BEGIN panel -->
            <div class="panel panel-inverse">
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                    <div class="row" v-if="oEvidencia">
                        <div class="col-12">
                            <p>
                                <strong>Código Evidencia: </strong
                                >{{ oEvidencia?.codigo }}
                            </p>
                            <p>
                                <strong>Descripción Evidencia: </strong
                                >{{ oEvidencia?.descripcion }}
                            </p>
                            <p>
                                <strong>Nombre del creador: </strong
                                >{{ oEvidencia?.nombre_creador }}
                            </p>
                            <p>
                                <strong>Fecha y hora de la creación: </strong
                                >{{ oEvidencia?.fecha_hora_creacion_t }}
                            </p>
                            <p>
                                <strong>Origen del archivo: </strong
                                >{{ oEvidencia?.origen_archivo }}
                            </p>
                            <p>
                                <strong>Fecha y hora del hallazgo: </strong
                                >{{ oEvidencia?.fecha_hora_hallazgo_t }}
                            </p>
                            <p>
                                <strong>Lugar de Recolección: </strong
                                >{{ oEvidencia?.lugar_recoleccion }}
                            </p>
                            <p>
                                <strong>Persona que recolectó: </strong
                                >{{ oEvidencia?.persona_recolector }}
                            </p>
                            <p>
                                <strong>Herramienta utilizada: </strong
                                >{{ oEvidencia?.herramienta_utilizada }}
                            </p>
                            <p>
                                <strong>Fecha de registro: </strong
                                >{{ oEvidencia.fecha_registro_t }}
                            </p>
                        </div>
                        <div class="col-12">
                            <label class="h5 font-weight-bold"
                                >Archivos cargados:</label
                            >
                            <div class="row">
                                <div
                                    class="col-md-3 img_cargado"
                                    v-for="(item, index) in oEvidencia.archivos"
                                >
                                    <div class="imagen">
                                        <img
                                            :src="item.url_file"
                                            alt=""
                                            class=""
                                        />
                                    </div>
                                    <div class="descripcion">
                                        <p :title="item.archivo" class="mb-0">
                                            {{ item.name }}
                                        </p>
                                        <p :title="item.hash_archivo">
                                            {{ item.hash_archivo }}
                                        </p>
                                    </div>
                                    <div class="acciones">
                                        <a
                                            :href="item.url_archivo"
                                            class="btn btn-sm btn-outline-primary"
                                            target="_blank"
                                        >
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        Aún no se seleccionó ningún código
                    </div>
                </div>
                <!-- END panel-body -->
            </div>
            <!-- END panel -->
        </div>
    </div>
</template>
<style scoped>
.img_cargado {
    align-items: center;
}
.img_cargado .imagen {
    height: 90px;
    display: flex;
    justify-content: center;
}

.img_cargado .imagen img {
    width: 100%;
    max-height: 90px;
    object-fit: contain;
}
.img_cargado .descripcion p {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.img_cargado .acciones {
    display: flex;
    gap: 3px;
}
</style>
