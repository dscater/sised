<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useCadenaCustodias } from "@/composables/cadena_custodias/useCadenaCustodias";
import { watch, ref, computed, defineEmits, onMounted, nextTick } from "vue";
import axios from "axios";
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

const { oCadenaCustodia, limpiarCadenaCustodia } = useCadenaCustodias();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oCadenaCustodia.value);
let switcheryInstance = null;
watch(
    () => props.open_dialog,
    async (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            document
                .getElementsByTagName("body")[0]
                .classList.add("modal-open");
            form = useForm(oCadenaCustodia.value);
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

const listEvidencias = ref([]);

const tituloDialog = computed(() => {
    return accion.value == 0
        ? `<i class="fa fa-plus"></i> Nueva Cadena de Custodia`
        : `<i class="fa fa-edit"></i> Editar Cadena de Custodia`;
});

const initializeSwitcher = () => {
    const accesoCheckbox = document.getElementById("acceso");
    if (accesoCheckbox) {
        // Destruye la instancia previa si existe
        // Inicializa Switchery
        switcheryInstance = new Switchery(accesoCheckbox, {
            color: "#0078ff",
        });
    }
};
const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("cadena_custodias.store")
            : route("cadena_custodias.update", form.id);

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
            limpiarCadenaCustodia();
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

const cargarListas = () => {
    cargarEvidencias();
};

const cargarEvidencias = async () => {
    axios.get(route("evidencias.listado")).then((response) => {
        listEvidencias.value = response.data.evidencias;
    });
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
                            <div class="col-md-4">
                                <label>Seleccionar Evidencia*</label>
                                <el-select
                                    :class="{
                                        'parsley-error':
                                            form.errors?.evidencia_id,
                                    }"
                                    v-model="form.evidencia_id"
                                    placeholder="- Seleccione -"
                                    no-match-text="Sin datos"
                                    filterable
                                >
                                    <el-option
                                        v-for="item in listEvidencias"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.codigo"
                                    ></el-option>
                                </el-select>
                                <ul
                                    v-if="form.errors?.evidencia_id"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.evidencia_id }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Responsable*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.responsable,
                                    }"
                                    v-model="form.responsable"
                                />
                                <ul
                                    v-if="form.errors?.responsable"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.responsable }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Cargo*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.cargo,
                                    }"
                                    v-model="form.cargo"
                                />
                                <ul
                                    v-if="form.errors?.cargo"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.cargo }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Acción Realizada*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.accion,
                                    }"
                                    v-model="form.accion"
                                />
                                <ul
                                    v-if="form.errors?.accion"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.accion }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Destino/Lugar*</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.destino,
                                    }"
                                    v-model="form.destino"
                                />
                                <ul
                                    v-if="form.errors?.destino"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.destino }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Fecha*</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.fecha,
                                    }"
                                    v-model="form.fecha"
                                />
                                <ul
                                    v-if="form.errors?.fecha"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.fecha }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Hora*</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    :class="{
                                        'parsley-error': form.errors?.hora,
                                    }"
                                    v-model="form.hora"
                                />
                                <ul
                                    v-if="form.errors?.hora"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.hora }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <label>Observaciones*</label>
                                <el-input
                                    type="textarea"
                                    :class="{
                                        'parsley-error':
                                            form.errors?.observaciones,
                                    }"
                                    v-model="form.observaciones"
                                    autosize
                                ></el-input>
                                <ul
                                    v-if="form.errors?.observaciones"
                                    class="parsley-errors-list filled"
                                >
                                    <li class="parsley-required">
                                        {{ form.errors?.observaciones }}
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
