<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useEvidencias } from "@/composables/evidencias/useEvidencias";
import { useAxios } from "@/composables/axios/useAxios";
import { watch, ref, computed, defineEmits, onMounted, nextTick } from "vue";
import MiDropZone from "@/Components/MiDropZone.vue";
const props = defineProps({
    open_dialog: {
        type: Boolean,
        default: false,
    },
    accion_dialog: {
        type: Number,
        default: 0,
    },
});

const { oEvidencia, limpiarEvidencia } = useEvidencias();
const { axiosGet } = useAxios();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oEvidencia);
watch(
    () => props.open_dialog,
    async (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            const accesoCheckbox = $("#acceso");
            document
                .getElementsByTagName("body")[0]
                .classList.add("modal-open");
            form = useForm(oEvidencia);
            if (form.id != 0) {
            }
        }
    }
);
watch(
    () => props.accion_dialog,
    (newValue) => {
        accion.value = newValue;
    }
);

const { flash } = usePage().props;

const tituloDialog = computed(() => {
    return accion.value == 0
        ? `<i class="fa fa-plus"></i> Nuevo Evidencia`
        : `<i class="fa fa-edit"></i> Editar Evidencia`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("evidencias.store")
            : route("evidencias.update", form.id);

    form.post(url, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            dialog.value = false;
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: `${flash.bien ? flash.bien : "Proceso realizado"}`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
            limpiarEvidencia();
            emits("envio-formulario");
        },
        onError: (err) => {
            console.log("ERROR");
            Swal.fire({
                icon: "info",
                title: "Error",
                text: `${
                    flash.error
                        ? flash.error
                        : err.error
                        ? err.error
                        : "Hay errores en el formulario"
                }`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
        },
    });
};

const emits = defineEmits(["cerrar-dialog", "envio-formulario"]);

watch(dialog, (newVal) => {
    if (!newVal) {
        emits("cerrar-dialog");
    }
});

const cerrarDialog = () => {
    dialog.value = false;
    document.getElementsByTagName("body")[0].classList.remove("modal-open");
};

const cargarListas = () => {};

// Activar el input file oculto
function triggerFileInput(index) {
    console.log(index);
    const input = document.getElementById(`fileInput${index}`);
    if (input) input.click();
}

// Procesar el nuevo archivo
function handleFileChange(event, index) {
    const file = event.target.files[0];
    if (!file) return;

    // Actualizar nombre del archivo
    form.cargados[index].archivo = file;
    form.cargados[index].name = file.name;
    form.cargados[index].hash_archivo = ">Por modificar<";

    // Crear URL temporal para previsualización
    const ext = file.name.split(".").pop().toLowerCase();
    const esImagen = ["jpg", "jpeg", "png", "webp", "gif"].includes(ext);

    form.cargados[index].url_file = esImagen
        ? URL.createObjectURL(file)
        : url_assets + "/imgs/attach.png";
}
const eliminarArchivo = (index) => {
    const archivo = form.cargados[index];
    form.eliminados.push(archivo.id);
    form.cargados.splice(index, 1);
};

const detectaArchivos = (files) => {
    form.archivos = files;
};

const detectaEliminados = (eliminados) => {
    form.eliminados = eliminados;
};

onMounted(() => {
    cargarListas();
});
</script>

<template>
    <div
        class="modal fade"
        :class="{
            show: dialog,
        }"
        id="modal-dialog-form"
        :style="{
            display: dialog ? 'block' : 'none',
        }"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" v-html="tituloDialog"></h4>
                    <button
                        type="button"
                        class="btn-close"
                        @click="cerrarDialog()"
                    ></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="enviarFormulario()">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label>Código único de Evidencia*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.codigo,
                                    }"
                                    v-model="form.codigo"
                                />
                                <ul
                                    v-if="form.errors?.codigo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.codigo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Descripción de la evidencia*</label>
                                <el-input
                                    type="textarea"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.descripcion,
                                    }"
                                    v-model="form.descripcion"
                                    autosize
                                ></el-input>
                                <ul
                                    v-if="form.errors?.descripcion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.descripcion }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Nombre del creador</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.nombre_creador,
                                    }"
                                    v-model="form.nombre_creador"
                                />
                                <ul
                                    v-if="form.errors?.nombre_creador"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.nombre_creador }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Fecha de la creación*</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.fecha_creacion,
                                    }"
                                    v-model="form.fecha_creacion"
                                />
                                <ul
                                    v-if="form.errors?.fecha_creacion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.fecha_creacion }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Hora de la creación*</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.hora_creacion,
                                    }"
                                    v-model="form.hora_creacion"
                                />
                                <ul
                                    v-if="form.errors?.hora_creacion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.hora_creacion }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Origen del archivo*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.origen_archivo,
                                    }"
                                    v-model="form.origen_archivo"
                                />
                                <ul
                                    v-if="form.errors?.origen_archivo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.origen_archivo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Fecha Hallazgo*</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.fecha_hallazgo,
                                    }"
                                    v-model="form.fecha_hallazgo"
                                />
                                <ul
                                    v-if="form.errors?.fecha_hallazgo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.fecha_hallazgo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Hora Hallazgo*</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.hora_hallazgo,
                                    }"
                                    v-model="form.hora_hallazgo"
                                />
                                <ul
                                    v-if="form.errors?.hora_hallazgo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.hora_hallazgo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Lugar de Recolección*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.lugar_recoleccion,
                                    }"
                                    v-model="form.lugar_recoleccion"
                                />
                                <ul
                                    v-if="form.errors?.lugar_recoleccion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.lugar_recoleccion }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Persona que recolectó*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.persona_recolector,
                                    }"
                                    v-model="form.persona_recolector"
                                />
                                <ul
                                    v-if="form.errors?.persona_recolector"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.persona_recolector }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Herramienta utilizada*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.herramienta_utilizada,
                                    }"
                                    v-model="form.herramienta_utilizada"
                                />
                                <ul
                                    v-if="form.errors?.herramienta_utilizada"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.herramienta_utilizada }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-2" v-if="form.id != 0">
                            <label class="h5 font-weight-bold"
                                >Archivos cargados:</label
                            >
                            <div
                                class="col-md-3 img_cargado"
                                v-for="(item, index) in form.cargados"
                            >
                                <div class="imagen">
                                    <img :src="item.url_file" alt="" class="" />
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
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-warning"
                                        @click.prevent="triggerFileInput(index)"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <input
                                        type="file"
                                        class="d-none"
                                        :id="'fileInput' + index"
                                        @change="
                                            handleFileChange($event, index)
                                        "
                                    />
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        @click.prevent="eliminarArchivo(index)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <hr class="mb-1 mt-2" />
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="h5 font-weight-bold"
                                    >Adjuntar archivos:</label
                                >
                                <MiDropZone
                                    :files="form.id == 0 ? form.archivos : []"
                                    @UpdateFiles="detectaArchivos"
                                    @addEliminados="detectaEliminados"
                                ></MiDropZone>
                                <ul
                                    v-if="form.errors?.archivos"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.archivos }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a
                        href="javascript:;"
                        class="btn btn-white"
                        @click="cerrarDialog()"
                        ><i class="fa fa-times"></i> Cerrar</a
                    >
                    <button
                        type="button"
                        @click="enviarFormulario()"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>
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
