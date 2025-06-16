<script setup>
import { useApp } from "@/composables/useApp";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { useAxios } from "@/composables/axios/useAxios";
import { ref, onMounted, onBeforeUnmount, watch } from "vue";
const props = defineProps({
    control_integridad: {
        type: Object,
        default: null,
    },
});
const { props: props_page } = usePage();
const { setLoading } = useApp();

const cargarControlIntegridad = () => {};
watch(
    () => props_page.notificacion.id,
    (newId, oldId) => {
        router.reload();
    }
);

onMounted(() => {
    setTimeout(() => {
        setLoading(false);
    }, 300);
});
onBeforeUnmount(() => {});
</script>
<template>
    <Head title="ControlIntegridads"></Head>

    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Inicio</a></li>
        <li class="breadcrumb-item">
            <Link :href="route('control_integridads.index')"
                >ControlIntegridades</Link
            >
        </li>
        <li class="breadcrumb-item active">Ver</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">ControlIntegridades > Ver</h1>
    <!-- END page-header -->

    <div class="row">
        <div class="col-md-12">
            <Link
                :href="route('control_integridads.index')"
                class="btn btn-outline-secondary mb-2"
                ><i class="fa fa-arrow-left"></i> Volver</Link
            >
            <!-- BEGIN panel -->
            <div class="panel panel-inverse">
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-12" v-if="props.control_integridad">
                            <h4>Información de Control de Integridad:</h4>
                            <p>
                                <strong>Fecha y Hora de Alteración: </strong
                                >{{
                                    props.control_integridad
                                        .fecha_hora_alteracion_t
                                }}
                            </p>
                            <p>
                                <strong>Encriptado original: </strong
                                >{{
                                    props.control_integridad.encriptado_original
                                }}
                            </p>
                            <p>
                                <strong>Encriptado de alteración: </strong
                                >{{
                                    props.control_integridad
                                        .encriptado_alteracion
                                }}
                            </p>
                        </div>
                        <div class="col-12">
                            <p>
                                <strong>Archivo:</strong>
                                {{
                                    props.control_integridad.evidencia_archivo
                                        .name
                                }}
                            </p>
                            <div class="row">
                                <div class="col-12">
                                    <img
                                        :src="
                                            props.control_integridad
                                                .evidencia_archivo.url_file
                                        "
                                        alt=""
                                        style="max-width: 100%"
                                    />
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <a
                                                :href="
                                                    props.control_integridad
                                                        .evidencia_archivo
                                                        .url_archivo
                                                "
                                                target="_blank"
                                                class="btn btn-outline-primary"
                                            >
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END panel-body -->
            </div>
            <!-- END panel -->
        </div>
    </div>
</template>
