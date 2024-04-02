--
-- PostgreSQL database dump
--

-- Dumped from database version 12.15 (Debian 12.15-1.pgdg110+1)
-- Dumped by pg_dump version 12.15 (Debian 12.15-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cargos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cargos (
    id smallint NOT NULL,
    name character varying(200) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cargos OWNER TO postgres;

--
-- Name: cargos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cargos_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cargos_id_seq OWNER TO postgres;

--
-- Name: cargos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cargos_id_seq OWNED BY public.cargos.id;


--
-- Name: ccp_locations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ccp_locations (
    id smallint NOT NULL,
    name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.ccp_locations OWNER TO postgres;

--
-- Name: ccp_locations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ccp_locations_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ccp_locations_id_seq OWNER TO postgres;

--
-- Name: ccp_locations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ccp_locations_id_seq OWNED BY public.ccp_locations.id;


--
-- Name: ccps; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ccps (
    id integer NOT NULL,
    ccp_location_id smallint NOT NULL,
    code character varying(20) NOT NULL,
    name character varying(255) NOT NULL,
    latitude numeric(9,6) NOT NULL,
    length numeric(9,6) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.ccps OWNER TO postgres;

--
-- Name: ccps_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ccps_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ccps_id_seq OWNER TO postgres;

--
-- Name: ccps_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ccps_id_seq OWNED BY public.ccps.id;


--
-- Name: employee_ccp; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employee_ccp (
    id integer NOT NULL,
    ccp_id integer NOT NULL,
    employee_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.employee_ccp OWNER TO postgres;

--
-- Name: employee_ccp_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employee_ccp_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.employee_ccp_id_seq OWNER TO postgres;

--
-- Name: employee_ccp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employee_ccp_id_seq OWNED BY public.employee_ccp.id;


--
-- Name: employees; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employees (
    id integer NOT NULL,
    person_id integer NOT NULL,
    code character varying(10) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.employees OWNER TO postgres;

--
-- Name: employees_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employees_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.employees_id_seq OWNER TO postgres;

--
-- Name: employees_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employees_id_seq OWNED BY public.employees.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO postgres;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO postgres;

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: people; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.people (
    id integer NOT NULL,
    identification_number character varying(15),
    first_name character varying(100) NOT NULL,
    last_name character varying(100) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.people OWNER TO postgres;

--
-- Name: people_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.people_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.people_id_seq OWNER TO postgres;

--
-- Name: people_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.people_id_seq OWNED BY public.people.id;


--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: rangos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.rangos (
    id smallint NOT NULL,
    name character varying(200) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.rangos OWNER TO postgres;

--
-- Name: rangos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.rangos_id_seq
    AS smallint
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rangos_id_seq OWNER TO postgres;

--
-- Name: rangos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.rangos_id_seq OWNED BY public.rangos.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    code character varying(15) NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: cargos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cargos ALTER COLUMN id SET DEFAULT nextval('public.cargos_id_seq'::regclass);


--
-- Name: ccp_locations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccp_locations ALTER COLUMN id SET DEFAULT nextval('public.ccp_locations_id_seq'::regclass);


--
-- Name: ccps id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccps ALTER COLUMN id SET DEFAULT nextval('public.ccps_id_seq'::regclass);


--
-- Name: employee_ccp id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_ccp ALTER COLUMN id SET DEFAULT nextval('public.employee_ccp_id_seq'::regclass);


--
-- Name: employees id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees ALTER COLUMN id SET DEFAULT nextval('public.employees_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: people id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.people ALTER COLUMN id SET DEFAULT nextval('public.people_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: rangos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rangos ALTER COLUMN id SET DEFAULT nextval('public.rangos_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cargos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cargos (id, name, created_at, updated_at) FROM stdin;
1	N/A	\N	\N
2	ABOGADO I	\N	\N
3	ABOGADO III	\N	\N
4	ASESOR LEGAL	\N	\N
5	ADMINISTRADOR III	\N	\N
6	ALBAÑIL	\N	\N
7	ALMACENISTA II	\N	\N
8	ANALISTA DE PERSONAL I	\N	\N
9	ANALISTA DE PRESUPUESTO  II	\N	\N
10	ANALISTA DE PRESUPUESTO  III	\N	\N
11	ARCHIVISTA I	\N	\N
12	ARQUITECTO I	\N	\N
13	ASEADOR	\N	\N
14	ASISTENTE ADMINISTRATIVO	\N	\N
15	ASISTENTE ADMINISTRATIVO III	\N	\N
16	ASISTENTE ADMINISTRATIVO IV	\N	\N
17	ASISTENTE DE ANALISTA I	\N	\N
18	ASISTENTE DE ANALISTA III	\N	\N
19	ASISTENTE DE BIBLIOTECA II	\N	\N
20	ASISTENTE DE ESTADISTICA II	\N	\N
21	ASISTENTE DE OFICINA I	\N	\N
22	ASISTENTE DE OFICINA III	\N	\N
23	ASISTENTE DE PRE-ESCOLAR	\N	\N
24	ASISTENTE DE VETERINARIA	\N	\N
25	AUXILIAR DE ENFERMERIA	\N	\N
26	AUXILIAR DE LABORATORIO	\N	\N
27	AUXILIAR DE SERVICIO DE OFICINA	\N	\N
28	AYUDANTE DEL DIRECTOR	\N	\N
29	AYUDANTE MECANICO	\N	\N
30	AYUDANTE SERVICIO DE COCINA	\N	\N
31	BARBERO	\N	\N
32	BIOANALISTA I	\N	\N
33	BIOANALISTA II	\N	\N
34	CAPELLAN I	\N	\N
35	CARPINTERO	\N	\N
36	COCINERO	\N	\N
37	COMPRADOR  JEFE  I	\N	\N
38	COMUNICADOR SOCIAL I	\N	\N
39	CONTABILISTA I	\N	\N
40	CONTADOR I	\N	\N
41	CONTADOR II	\N	\N
42	COORDINADOR DESARROLLO DE RRHH	\N	\N
43	AYUDANTE DE ALMACEN	\N	\N
44	DESPENSERO	\N	\N
45	DIBUJANTE  I	\N	\N
46	DIETISTA I	\N	\N
47	DIRECTOR GENERAL	\N	\N
48	ECONOMA I	\N	\N
49	ELECTRICISTA DE ALTA TENSION	\N	\N
50	ELECTROMECANICO	\N	\N
51	ENFERMERA III	\N	\N
52	ENFERMERO (A) I	\N	\N
53	ENFERMERO (A) II	\N	\N
54	ENTRENADOR DEPORTIVO  I	\N	\N
55	ESTADISTICO I	\N	\N
56	FOTOGRAFO II	\N	\N
57	FUNCIONARIO POLICIAL	\N	\N
58	HIGIENISTA DENTAL I	\N	\N
59	INSTRUCTOR	\N	\N
60	INVESTIGADOR SOCIAL I	\N	\N
61	JEFE ARMAMENTO	\N	\N
62	JEFE ATENCIO COMUNITARIA	\N	\N
63	JEFE ATENCION AL PUBLICO	\N	\N
64	JEFE BIENESTAR SOCIAL	\N	\N
65	JEFE BRIGADA ACCIONES ESPECIALES	\N	\N
66	JEFE BRIGADA CANINA	\N	\N
67	JEFE BRIGADA CICLISTA	\N	\N
68	JEFE BRIGADA ESCOLAR	\N	\N
69	JEFE BRIGADA ESPECIAL	\N	\N
70	JEFE BRIGADA MOTORIZADA	\N	\N
71	JEFE BRIGADA PATRULLAJE VEHICULAR	\N	\N
72	DIRECTOR C.C.P 1	\N	\N
73	DIRECTOR C.C.P 2	\N	\N
74	DIRECTOR C.C.P 3	\N	\N
75	DIRECTOR C.C.P 4	\N	\N
76	DIRECTOR C.C.P 5	\N	\N
77	DIRECTOR C.C.P 6	\N	\N
78	DIRECTOR C.C.P 7	\N	\N
79	DIRECTOR C.C.P 8	\N	\N
80	DIRECTOR C.C.P 9	\N	\N
81	DIRECTOR C.C.P 10	\N	\N
82	DIRECTOR C.C.P 11	\N	\N
83	DIRECTOR C.C.P 12	\N	\N
84	DIRECTOR C.C.P 13	\N	\N
85	DIRECTOR C.C.P 14	\N	\N
86	JEFE COMPRAS	\N	\N
87	JEFE COMUNICACIONES	\N	\N
88	JEFE CONSULTORIA JURIDICA	\N	\N
89	JEFE DE PREESCOLAR	\N	\N
90	JEFE DEL CUARTEL	\N	\N
91	JEFE DIVISION ADMINISTRACION	\N	\N
92	JEFE DIVISION DE INFORMATICA	\N	\N
93	JEFE DIVISION INSPECTORIA GENERAL	\N	\N
94	JEFE DIVISION NVESTIGACIONES CRIMINALES	\N	\N
95	JEFE DIVISION OPERACIONES	\N	\N
96	JEFE DIVISION PLANIFICACION	\N	\N
97	JEFE DIVISION RECURSOS HUMANOS	\N	\N
98	JEFE DPTO SEGURIDAD Y SALUD OCUPACIONAL	\N	\N
99	JEFE ECONOMATO	\N	\N
100	JEFE EDUCACION	\N	\N
101	JEFE ESTADISTICA	\N	\N
102	JEFE HABILITADURIA	\N	\N
103	JEFE IUPM	\N	\N
104	JEFE LABORATORIO INFORMATICA	\N	\N
105	JEFE LOGISTICA	\N	\N
106	JEFE NOMINA	\N	\N
107	JEFE PRESUPUESTO	\N	\N
108	JEFE REGIMEN DISCIPLINARIO	\N	\N
109	JEFE RELACIONES INTERISTUCIONALES	\N	\N
110	JEFE RETEN	\N	\N
111	JEFE RURAL	\N	\N
112	JEFE TALLER	\N	\N
113	JEFE UANAPEM	\N	\N
114	LATONERO Y PINTOR	\N	\N
115	LAVADOR Y ENGRASADOR	\N	\N
116	MAESTRA DE PRESCOLAR	\N	\N
117	MECANICO AUTOMOTRIZ	\N	\N
118	MECANICO DE MOTO	\N	\N
119	MED. ESPECIALISTA II	\N	\N
120	MED. ESPECIALISTA I	\N	\N
121	MEDICO GENERAL II	\N	\N
122	MENSAJERO	\N	\N
123	MESONERO	\N	\N
124	ODONTOLOGO I	\N	\N
125	ODONTOLOGO II	\N	\N
126	OPERADOR DE TELECOMUNICACIONES	\N	\N
127	OPERADOR EQUIPO COMPUTACION I	\N	\N
128	OPERADOR EQUIPO COMPUTACION II	\N	\N
129	OPERADOR EQUIPO COMPUTACION III	\N	\N
130	PINTOR	\N	\N
131	PLANIFICADOR I	\N	\N
132	PLANIFICADOR II	\N	\N
133	PLANIFICADOR III	\N	\N
134	PLOMERO	\N	\N
135	PRACTICO DE ARMAMENTO NC	\N	\N
136	PROMOTOR DE BIENESTAR SOCIAL	\N	\N
137	PSICOLOGO I	\N	\N
138	PSICOLOGO II	\N	\N
139	REPARTIDOR DE ALIMENTO	\N	\N
140	SECRETARIA EJECUTIVA III	\N	\N
141	OPERADOR DE MANTENIMIENTO Y FUNCIONAMIENTO	\N	\N
142	SECRETARIA I	\N	\N
143	SECRETARIA II	\N	\N
144	SECRETARIA III	\N	\N
145	SUB DIRECTOR GENERAL	\N	\N
146	TELEFONISTA	\N	\N
147	TRABAJADOR SOCIAL I	\N	\N
148	OBRERO	\N	\N
149	COORDINADOR 16 DE JULIO	\N	\N
150	JEFE DE LA UNIDAD DE REGISTRO Y CONTROL	\N	\N
151	PROGRAMADOR	\N	\N
152	AUDITOR INTERNO	\N	\N
153	AUXILIAR VETERINARIO	\N	\N
154	PROGRAMADOR DE SISTEMAS (PI)	\N	\N
155	PROGRAMADOR DE SISTEMAS (PII)	\N	\N
156	PROGRAMADOR DE SISTEMAS (PIII)	\N	\N
157	DIRECTOR (E) DE ADMINISTRACION DEL IAPEM	\N	\N
158	DIRECTOR (E) DE LA OFICINA DE SISTEMAS Y TECNOLOGIA DE INFORMACION	\N	\N
159	DIRECTOR (E) DE LA INSPECTORIA PARA EL CONTROL DE LA ACTUACION POLICIAL	\N	\N
160	DIRECTOR (E) DE LA OFICINA DE PLANIFICACION DEL IAPEM	\N	\N
161	SUPERVISOR GENERAL DE LA UNIDAD DE VIGILANCIA Y PATRULLAJE A PIE	\N	\N
162	DIRECTOR (E) DE LA OFICINA DE RECURSOS HUMANOS	\N	\N
163	DIRECTOR (E) OFICINA CONSULTORIA JURIDICA	\N	\N
164	JEFE (E) SECCION DE BIENES	\N	\N
165	JEFE (E) DE ALMACEN	\N	\N
166	JEFE (E) SECCION REGISTRO Y CONTROL DE HISTORIALES	\N	\N
167	JEFE (E) DEPARTAMENTO BIENESTAR SOCIAL	\N	\N
168	PROMOTOR SOCIAL (TI)	\N	\N
169	PROMOTOR SOCIAL (TII)	\N	\N
170	PROMOTOR SOCIAL (TIII)	\N	\N
171	ABOGADO (PI)	\N	\N
172	ABOGADO (PII)	\N	\N
173	ABOGADO (PIII)	\N	\N
174	CRIMINOLOGO (PI)	\N	\N
175	CRIMINOLOGO (PII)	\N	\N
176	CRIMINOLOGO (PIII)	\N	\N
177	INTRUCTOR (PI)	\N	\N
178	INTRUCTOR (PII)	\N	\N
179	INTRUCTOR (PIII)	\N	\N
180	ARCHIVISTA (BI)	\N	\N
181	ARCHIVISTA (BII)	\N	\N
182	ARCHIVISTA (BIII)	\N	\N
183	ASISTENTE ADMINISTRATIVO (TI)	\N	\N
184	ASISTENTE ADMINISTRATIVO (TII)	\N	\N
185	ASISTENTE ADMINISTRATIVO (TIII)	\N	\N
186	ASISTENTE ADMINISTRATIVO (B)	\N	\N
187	ASISTENTE ADMINISTRATIVO (BI)	\N	\N
188	ASISTENTE ADMINISTRATIVO (BII)	\N	\N
189	ASISTENTE ADMINISTRATIVO (BIII)	\N	\N
190	CONTADOR (P)	\N	\N
191	CONTADOR (PI)	\N	\N
192	CONTADOR (PII)	\N	\N
193	CONTADOR (PIII)	\N	\N
194	POLITOLOGO (PI)	\N	\N
195	POLITOLOGO (PII)	\N	\N
196	POLITOLOGO (PIII)	\N	\N
197	ADMINISTRADORA (PI)	\N	\N
198	ADMINISTRADORA (PII)	\N	\N
199	ADMINISTRADORA (PIII)	\N	\N
200	ASISTENTE DE OFICINA (BI)	\N	\N
201	ASISTENTE DE OFICINA (BII)	\N	\N
202	ASISTENTE DE OFICINA (BIII)	\N	\N
203	SECRETARIA (BI)	\N	\N
204	SECRETARIA (BII)	\N	\N
205	SECRETARIA (BIII)	\N	\N
206	PSICOPEDAGOGO (TI)	\N	\N
207	PSICOPEDAGOGO (TII)	\N	\N
208	PSICOPEDAGOGO (TIII)	\N	\N
209	OPERADOR DE EQUIPO DE EMERGENCIA (TI)	\N	\N
210	OPERADOR DE EQUIPO DE EMERGENCIA (TII)	\N	\N
211	OPERADOR DE EQUIPO DE EMERGENCIA (TIII)	\N	\N
212	TECNICO EN INFORMATICA (TI)	\N	\N
213	TECNICO EN INFORMATICA (BI)	\N	\N
214	TECNICO EN INFORMATICA (BII)	\N	\N
215	TECNICO EN INFORMATICA (BIII)	\N	\N
216	AUX. SERV. OFICINA (B)	\N	\N
217	COCINERA (B)	\N	\N
218	AUXILIAR DE COCINA (B)	\N	\N
219	ASEADOR (B)	\N	\N
220	ASISTENTE DE OFICINA II	\N	\N
\.


--
-- Data for Name: ccp_locations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ccp_locations (id, name, created_at, updated_at) FROM stdin;
1	CCP 01 MERIDA	\N	\N
2	CCP 02 JACINTO PLAZA	\N	\N
3	CCP 03 EJIDO	\N	\N
4	CCP 04 LAGUNILLAS	\N	\N
5	CCP 05 TOVAR	\N	\N
6	CCP 06 BAILADORES	\N	\N
7	CCP 07 CANAGUA	\N	\N
8	CCP 08 EL VIGIA	\N	\N
9	CCP 09 SANTA ELENA DE ARENALES	\N	\N
10	CCP 10 NUEVA BOLIVIA	\N	\N
11	CCP 11 MUCUCHIES	\N	\N
12	CCP 12 SANTO DOMINGO	\N	\N
13	CCP 13 TIMOTES	\N	\N
14	CCP 14 SANTA MARIA DE CAPARO	\N	\N
15	DIRECCION GENERAL	\N	\N
\.


--
-- Data for Name: ccps; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ccps (id, ccp_location_id, code, name, latitude, length, created_at, updated_at) FROM stdin;
39	1	CCP0101	ALCAIDESA RETEN FEMENINO	8.582503	-71.172576	\N	\N
40	1	CCP0102	COORDINACION DE INVESTIGACIONES DEL CCP MERIDA CASILLA LOS SAUZALES	8.582503	-71.172576	\N	\N
41	1	CCP0103	COORDINADOR DE VIGILANCIA Y PATRULLAJE DEL CVP	8.582503	-71.172576	\N	\N
42	1	CCP0104	DIRECCION ESTADAL DE TELEINFORMATICA	8.582503	-71.172576	\N	\N
43	1	CCP0105	ESTACION POLICIAL BELEN	8.582503	-71.172576	\N	\N
44	1	CCP0106	ESTACION POLICIAL BELEN (UNIDAD DE PATRULLAJE A PIE)	8.582503	-71.172576	\N	\N
45	1	CCP0107	ESTACION POLICIAL CAMPO DE ORO	8.582503	-71.172576	\N	\N
46	1	CCP0108	ESTACION POLICIAL EL VALLE	8.582503	-71.172576	\N	\N
47	1	CCP0109	ESTACION POLICIAL LOS CUROS	8.582503	-71.172576	\N	\N
48	1	CCP0110	ESTACION POLICIAL LOS SAUZALES	8.582503	-71.172576	\N	\N
49	1	CCP0111	FUNDACION DEL NINO	8.582503	-71.172576	\N	\N
50	1	CCP0112	OFICINA DE ATENCION A LA VICTIMA	8.582503	-71.172576	\N	\N
51	1	CCP0113	PALACIO DE GOBIERNO	8.582503	-71.172576	\N	\N
52	1	CCP0114	PATRULLAJE A PIE	8.582503	-71.172576	\N	\N
53	1	CCP0115	POLICIA COMUNAL AVENIDA 2 LORA	8.582503	-71.172576	\N	\N
54	1	CCP0116	RESIDENCIA DEL GOBERNADOR	8.582503	-71.172576	\N	\N
55	1	CCP0117	SEDE DE LA UNIDAD CANINA	8.582503	-71.172576	\N	\N
56	1	CCP0118	SERVICIOS GENERALES CCP1	8.582503	-71.172576	\N	\N
57	1	CCP0119	UNIDAD DE PATRULLAJE A PIE	8.582503	-71.172576	\N	\N
58	1	CCP0120	UNIDAD DE PATRULLAJE VEHICULAR	8.582503	-71.172576	\N	\N
59	1	CCP0121	UNIDAD PATRULLAJE CICLISTA (AVENIDA 7 Y 8 ENTRE EL CEMENTERIO MUNICIPAL EL ESPEJO)	8.582503	-71.172576	\N	\N
60	2	CCP0201	ESTACION POLICIAL 5 AGUILAS	8.566767	-71.174383	\N	\N
61	2	CCP0202	ESTACION POLICIAL ARICAGUA	8.566767	-71.174383	\N	\N
62	2	CCP0203	ESTACION POLICIAL EL ARENAL	8.566767	-71.174383	\N	\N
63	2	CCP0204	ESTACION POLICIAL EL MORRO	8.566767	-71.174383	\N	\N
64	2	CCP0205	ESTACION POLICIAL LOS NEVADOS	8.566767	-71.174383	\N	\N
65	2	CCP0206	ESTACION POLICIAL SAN RAFAEL	8.566767	-71.174383	\N	\N
66	2	CCP0207	SECRETARIA DE APOYO DEL CCP2	8.566767	-71.174383	\N	\N
67	2	CCP0208	SERVICIOS GENERALES CCP2	8.566767	-71.174383	\N	\N
68	3	CCP0301	ESTACION POLICIAL SAN JOSE	8.546467	-71.242675	\N	\N
69	3	CCP0302	MODULO DE SERVICIO ASOPRIETO	8.546467	-71.242675	\N	\N
70	3	CCP0303	MODULO DE SERVICIO CENTRO COMERCIAL CENTENARIO	8.546467	-71.242675	\N	\N
71	3	CCP0304	SERVICIOS GENERALES CCP3	8.546467	-71.242675	\N	\N
72	4	CCP0401	CENTRO DE OPERACIONES POLICIALES	8.504628	-71.388778	\N	\N
73	4	CCP0402	ESTACION POLICIAL CHIGUARA	8.504628	-71.388778	\N	\N
74	4	CCP0403	ESTACION POLICIAL LA TRAMPA (SERVICIO INTEGRADO DE PATRULLAJE INTELIGENTE)	8.504628	-71.388778	\N	\N
75	4	CCP0404	ESTACION POLICIAL SAN JUAN	8.504628	-71.388778	\N	\N
76	4	CCP0405	OFICINA DE ATENCION A LA VICTIMA	8.504628	-71.388778	\N	\N
77	4	CCP0406	OFICINA DE RECEPCION DE DENUNCIAS	8.504628	-71.388778	\N	\N
78	4	CCP0407	PATRULLAJE MOTORIZADO	8.504628	-71.388778	\N	\N
79	4	CCP0408	SERVICIO INTEGRADO DE PATRULLAJE INTELIGENTE	8.504628	-71.388778	\N	\N
80	4	CCP0409	SERVICIOS GENERALES CCP4	8.504628	-71.388778	\N	\N
81	5	CCP0501	ESTACION POLICIAL CAÃÂO TIGRE	8.330705	-71.752917	\N	\N
82	5	CCP0502	ESTACION POLICIAL SANTA CRUZ DE MORA	8.330705	-71.752917	\N	\N
83	5	CCP0503	ESTACION POLICIAL TOVAR	8.330705	-71.752917	\N	\N
84	5	CCP0504	ESTACION POLICIAL ZEA	8.330705	-71.752917	\N	\N
85	5	CCP0505	SERVICIOS GENERALES CCP5	8.330705	-71.752917	\N	\N
86	6	CCP0601	ESTACION POLICIAL GUARAQUE	8.250791	-71.829036	\N	\N
87	6	CCP0602	ESTACION POLICIAL LA PLAYA	8.250791	-71.829036	\N	\N
88	6	CCP0603	ESTACION POLICIAL MESA DE QUINTERO	8.250791	-71.829036	\N	\N
89	6	CCP0604	SERVICIOS GENERALES CCP6	8.250791	-71.829036	\N	\N
90	7	CCP0701	ESTACION POLICIAL EL MOLINO	8.125046	-71.460138	\N	\N
91	7	CCP0702	ESTACION POLICIAL MUCUCHACHI	8.125046	-71.460138	\N	\N
92	7	CCP0703	ESTACION POLICIAL MUCUTUY	8.125046	-71.460138	\N	\N
93	7	CCP0704	POLICIA COMUNAL	8.125046	-71.460138	\N	\N
94	7	CCP0705	SERVICIO DE VIGILANCIA Y PATRULLAJE	8.125046	-71.460138	\N	\N
95	7	CCP0706	SERVICIOS GENERALES CCP7	8.125046	-71.460138	\N	\N
96	8	CCP0801	CENTRO CULTURAL MARIANO PICON SALAS	8.618684	-71.648808	\N	\N
97	8	CCP0802	COORDINACION DE POLICIA COMUNAL	8.618684	-71.648808	\N	\N
98	8	CCP0803	COORDINACION DE VIGILANCIA Y PATRULLAJE	8.618684	-71.648808	\N	\N
99	8	CCP0804	ESTACION POLICIAL LA BLANCA	8.618684	-71.648808	\N	\N
100	8	CCP0805	ESTACION POLICIAL LA PALMITA	8.618684	-71.648808	\N	\N
101	8	CCP0806	ESTACION POLICIAL LOS NARANJOS	8.618684	-71.648808	\N	\N
102	8	CCP0807	ESTACION POLICIAL MUCUJEPE	8.618684	-71.648808	\N	\N
103	8	CCP0808	HOSPITAL II EL VIGIA	8.618684	-71.648808	\N	\N
104	8	CCP0809	INSTITUTO NACIONAL DE TRANSPORTE TERRESTRE	8.618684	-71.648808	\N	\N
105	8	CCP0810	JEFE DE LA ESTACION POLICIAL LA BLANCA	8.618684	-71.648808	\N	\N
106	8	CCP0811	MERCAL ZONA INDUSTRIAL	8.618684	-71.648808	\N	\N
107	8	CCP0812	OFICINA DE ATENCION A LA VICTIMA	8.618684	-71.648808	\N	\N
108	8	CCP0813	OFICINA DE MANTENIMIENTO DE UNIDADES	8.618684	-71.648808	\N	\N
109	8	CCP0814	OFICINA DE SECRETARIA DE APOYO	8.618684	-71.648808	\N	\N
110	8	CCP0815	PATRULLAJE MOTORIZADO	8.618684	-71.648808	\N	\N
111	8	CCP0816	POLICIA COMUNAL	8.618684	-71.648808	\N	\N
112	8	CCP0817	SECCION DE REGISTRO Y CONTROL DE DETENIDOS	8.618684	-71.648808	\N	\N
113	8	CCP0818	SERVICIO DE POLICIA COMUNAL	8.618684	-71.648808	\N	\N
114	8	CCP0819	SERVICIOS GENERALES CCP8	8.618684	-71.648808	\N	\N
115	9	CCP0901	ESTACION POLICIAL GUAYABONES	8.819074	-71.464595	\N	\N
116	9	CCP0902	ESTACION POLICIAL LA AZULITA	8.819074	-71.464595	\N	\N
117	9	CCP0903	ESTACION POLICIAL SAN RAFAEL DE ALCAZAR	8.819074	-71.464595	\N	\N
118	9	CCP0904	SERVICIOS GENERALES CCP9	8.819074	-71.464595	\N	\N
119	10	CCP1001	ESTACION POLICIAL ARAPUEY	9.147717	-71.097684	\N	\N
120	10	CCP1002	ESTACION POLICIAL LAS VIRTUDES	9.147717	-71.097684	\N	\N
121	10	CCP1003	ESTACION POLICIAL NUEVA BOLIVIA	9.147717	-71.097684	\N	\N
122	10	CCP1004	ESTACION POLICIAL PALMARITO	9.147717	-71.097684	\N	\N
123	10	CCP1005	ESTACION POLICIAL SANTA APOLONIA	9.147717	-71.097684	\N	\N
124	10	CCP1006	ESTACION POLICIAL TORONDOY	9.147717	-71.097684	\N	\N
125	10	CCP1007	ESTACION POLICIAL TUCANI	9.147717	-71.097684	\N	\N
126	10	CCP1008	SEDE DEL BANCO AGRICOLA	9.147717	-71.097684	\N	\N
127	10	CCP1009	SERVICIOS GENERALES CCP10	9.147717	-71.097684	\N	\N
128	11	CCP1101	ESTACION POLICIAL CACUTE	8.747761	-70.921489	\N	\N
129	11	CCP1102	ESTACION POLICIAL MUCUCHIES	8.747761	-70.921489	\N	\N
130	11	CCP1103	ESTACION POLICIAL MUCURUBA	8.747761	-70.921489	\N	\N
131	11	CCP1104	ESTACION POLICIAL TABAY	8.747761	-70.921489	\N	\N
132	11	CCP1105	SERVICIOS GENERALES CCP11	8.747761	-70.921489	\N	\N
133	12	CCP1201	SERVICIOS GENERALES CCP12	8.860109	-70.697250	\N	\N
134	13	CCP1301	SERVICIOS GENERALES CCP13	8.985994	-70.738954	\N	\N
135	14	CCP1401	SERVICIOS GENERALES CCP14	7.715270	-71.465785	\N	\N
136	15	DGP0101	ARCHIVO PASIVO	8.590401	-71.154990	\N	\N
137	15	DGP0102	ASOCIACION DE JUBILADOS Y PENSIONADOS	8.590401	-71.154990	\N	\N
138	15	DGP0104	CONSEJO DISCIPLINARIO	8.590401	-71.154990	\N	\N
139	15	DGP0105	COORDINACION DEL SERVICIO DE VIGILANCIA Y TRANSPORTE TERRESTRE EL ANIS	8.590401	-71.154990	\N	\N
140	15	DGP0106	CUADRANTES Y PATRULLAJE INTELIGENTE	8.590401	-71.154990	\N	\N
141	15	DGP0107	DEPARTAMENTO DE BIENESTAR SOCIAL	8.590401	-71.154990	\N	\N
142	15	DGP0108	DEPARTAMENTO DE EVALUACION DEL DESEMPENO	8.590401	-71.154990	\N	\N
143	15	DGP0109	DIEMP	8.590401	-71.154990	\N	\N
144	15	DGP0110	DIRECCION DE CONTROL DE REUNIONES PUBLICAS Y MANIFESTACIONES	8.590401	-71.154990	\N	\N
145	15	DGP0111	DIRECCION DE INTELIGENCIA ESTRATEGICA Y PREVENTIVA	8.590401	-71.154990	\N	\N
146	15	DGP0112	DIRECCION DE OPERACIONES	8.590401	-71.154990	\N	\N
147	15	DGP0113	DIRECCION DE OPERACIONES UENNAPEM EJIDO	8.590401	-71.154990	\N	\N
148	15	DGP0114	DIRECCION DE OPERACIONES UENNAPEM EL PARAMO	8.590401	-71.154990	\N	\N
149	15	DGP0115	DIRECCION DE OPERACIONES UENNAPEM EL VIGIA	8.590401	-71.154990	\N	\N
150	15	DGP0116	DIRECCION DE OPERACIONES UENNAPEM LAGUNILLAS	8.590401	-71.154990	\N	\N
151	15	DGP0117	DIRECCION DE OPERACIONES UENNAPEM MERIDA	8.590401	-71.154990	\N	\N
152	15	DGP0118	DIRECCION DE OPERACIONES UENNAPEM TOVAR	8.590401	-71.154990	\N	\N
153	15	DGP0120	DIRECCION DE RECURSOS HUMANOS	8.590401	-71.154990	\N	\N
154	15	DGP0121	DIRECCION GENERAL	8.590401	-71.154990	\N	\N
155	15	DGP0122	DIRECCION GENERAL SECCION DE REGISTRO Y RESGUARDO DE EVIDENCIAS	8.590401	-71.154990	\N	\N
156	15	DGP0123	INSPECTORIA PARA EL CONTROL DE LA ACTUACION POLICIAL	8.590401	-71.154990	\N	\N
157	15	DGP0124	OFICINA DE ADMINISTRACION	8.590401	-71.154990	\N	\N
158	15	DGP0125	OFICINA DE ASESORIA JURIDICA	8.590401	-71.154990	\N	\N
159	15	DGP0126	OFICINA DE ATENCION CIUDADANA	8.590401	-71.154990	\N	\N
160	15	DGP0127	OFICINA DE COMUNICACIONES Y RELACIONES INSTITUCIONALES	8.590401	-71.154990	\N	\N
161	15	DGP0128	OFICINA DE PLANIFICACION Y PRESUPUESTO	8.590401	-71.154990	\N	\N
162	15	DGP0129	OFICINA DE SIETPOL	8.590401	-71.154990	\N	\N
163	15	DGP0130	OFICINA DE SISTEMAS Y TECNOLOGIA DE INFORMACION	8.590401	-71.154990	\N	\N
164	15	DGP0131	SALA SITUACIONAL	8.590401	-71.154990	\N	\N
165	15	DGP0132	SECCION DE CONTROL Y MANTENIMIENTO DE ARMAMENTO	8.590401	-71.154990	\N	\N
166	15	DGP0133	SECCION DE EDUCACION	8.590401	-71.154990	\N	\N
167	15	DGP0134	SECCION DE TRANSPORTE Y MANTENIMIENTO 	8.590401	-71.154990	\N	\N
168	15	DGP0135	SECRETARIA DE IGUALDAD Y EQUIDAD DE GENERO	8.590401	-71.154990	\N	\N
169	15	DGP0136	SEDE CAPPOLIMER DIAGONAL CAMARA DE COMERCIO	8.590401	-71.154990	\N	\N
170	15	DGP0137	SEGURIDAD Y SALUD LABORAL	8.590401	-71.154990	\N	\N
171	15	DGP0138	SUB-DIRECCION	8.590401	-71.154990	\N	\N
172	15	DGP0139	UNIDAD DE PATRULLAJE RURAL	8.590401	-71.154990	\N	\N
\.


--
-- Data for Name: employee_ccp; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employee_ccp (id, ccp_id, employee_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: employees; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employees (id, person_id, code, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_reset_tokens_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2019_12_14_000001_create_personal_access_tokens_table	1
5	2024_03_05_184932_create_permission_tables	1
6	2024_03_20_144359_create_people_table	1
7	2024_03_20_152501_create_employees_table	1
8	2024_03_20_181005_create_ccps_table	1
9	2024_03_20_181627_create_employee_ccp_table	1
10	2024_04_01_140428_create_cargos_table	1
11	2024_04_01_191854_create_rangos_table	1
\.


--
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
\.


--
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
1	App\\Models\\User	1
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: people; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.people (id, identification_number, first_name, last_name, created_at, updated_at) FROM stdin;
1	90808241	Rachelle	Keebler	2024-04-02 17:59:51	2024-04-02 17:59:51
2	70120114	Isaiah	Daugherty	2024-04-02 17:59:51	2024-04-02 17:59:51
3	62923775	Emmy	Harris	2024-04-02 17:59:51	2024-04-02 17:59:51
4	46635497	Joel	Armstrong	2024-04-02 17:59:51	2024-04-02 17:59:51
5	86696204	Katheryn	Cummings	2024-04-02 17:59:51	2024-04-02 17:59:51
6	23804658	Adonis	Kutch	2024-04-02 17:59:51	2024-04-02 17:59:51
7	14048692	Easter	Cummerata	2024-04-02 17:59:51	2024-04-02 17:59:51
8	80892331	Bertram	Emard	2024-04-02 17:59:51	2024-04-02 17:59:51
9	83948139	Zaria	Kuhn	2024-04-02 17:59:51	2024-04-02 17:59:51
10	31560743	Nya	Buckridge	2024-04-02 17:59:51	2024-04-02 17:59:51
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
1	FRNS83VeVyyNCxtYCk3y	web	2024-04-02 17:59:50	2024-04-02 17:59:50
2	2FgTGiAAUkxiYANEWPHL	web	2024-04-02 17:59:50	2024-04-02 17:59:50
3	PzbeDPTjaDHqwJM8T1t4	web	2024-04-02 17:59:50	2024-04-02 17:59:50
4	xkVtk1nKiUlBwEF2H6ZM	web	2024-04-02 17:59:50	2024-04-02 17:59:50
5	KJaa2qX5LcEb4Fsw7GsO	web	2024-04-02 17:59:50	2024-04-02 17:59:50
6	LLOyAbQzGQ3mnivqISwr	web	2024-04-02 17:59:50	2024-04-02 17:59:50
7	NfbFBVr109shPEVx9BSX	web	2024-04-02 17:59:50	2024-04-02 17:59:50
8	emZYomF5ym8cYDG87s9e	web	2024-04-02 17:59:50	2024-04-02 17:59:50
9	VcWjaHHkNRJrmAlHBfyA	web	2024-04-02 17:59:50	2024-04-02 17:59:50
10	qq3zuMd15GomTogLeldQ	web	2024-04-02 17:59:50	2024-04-02 17:59:50
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: rangos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.rangos (id, name, created_at, updated_at) FROM stdin;
1	N/A	\N	\N
2	COMISARIO GENERAL	\N	\N
3	COMISARIO JEFE	\N	\N
4	COMISARIO	\N	\N
5	SUB COMISARIO	\N	\N
6	INSPECTOR JEFE	\N	\N
7	INSPECTOR	\N	\N
8	SUB INSPECTOR	\N	\N
9	SARGENTO MAYOR	\N	\N
10	SARGENTO PRIMERO	\N	\N
11	SARGENTO SEGUNDO	\N	\N
12	CABO PRIMERO	\N	\N
13	CABO SEGUNDO	\N	\N
14	DISTINGUIDO	\N	\N
15	AGENTE	\N	\N
16	AGENTE CONDUCTOR	\N	\N
17	COMISIONADO JEFE	\N	\N
18	COMISIONADO AGREGADO	\N	\N
19	COMISIONADO	\N	\N
20	SUPERVISOR JEFE	\N	\N
21	SUPERVISOR AGREGADO	\N	\N
22	SUPERVISOR	\N	\N
23	OFICIAL JEFE	\N	\N
24	OFICIAL AGREGADO	\N	\N
25	OFICIAL	\N	\N
\.


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
1	Administrador	web	2024-04-02 17:59:49	2024-04-02 17:59:49
2	9JOkmyeYprO5VGjUsxJB	web	2024-04-02 17:59:50	2024-04-02 17:59:50
3	2JtUzffv7ODZGIh87BBj	web	2024-04-02 17:59:50	2024-04-02 17:59:50
4	91ODfRFAKrkZl6TzAv7t	web	2024-04-02 17:59:50	2024-04-02 17:59:50
5	MpaQT5rogpqbcSJX4kYt	web	2024-04-02 17:59:50	2024-04-02 17:59:50
6	4KozC6tK7nlhrkb3KUwi	web	2024-04-02 17:59:50	2024-04-02 17:59:50
7	ev7xRGBY8OJ5mag84ICs	web	2024-04-02 17:59:50	2024-04-02 17:59:50
8	wJ8vsNnBCzOII73VQV9G	web	2024-04-02 17:59:50	2024-04-02 17:59:50
9	YSQjzxke0JpcVGAWEsrW	web	2024-04-02 17:59:50	2024-04-02 17:59:50
10	GfF6aZ4AjicEwMlEOtuf	web	2024-04-02 17:59:50	2024-04-02 17:59:50
11	eWZsXlaQLoeXe2JOuW2D	web	2024-04-02 17:59:50	2024-04-02 17:59:50
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, code, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	12345678	Jean Pier	jeanpier@gmail.com	\N	$2y$12$OR0EI5ixCl8VxYPnmc1lve/AwoADpBTgAOgDIKlTMFhBttHdJsYO2	\N	2024-04-02 17:59:49	2024-04-02 17:59:49
2	95007748	Kirsten Christiansen	mbalistreri@example.com	2024-04-02 17:59:50	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	IPY6XPZzCf	2024-04-02 17:59:51	2024-04-02 17:59:51
3	52004664	Ronny Batz	orin38@example.net	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	awwwaMOLz4	2024-04-02 17:59:51	2024-04-02 17:59:51
4	35556423	Alessandro Lemke	weston.borer@example.com	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	Lxn73yvwaN	2024-04-02 17:59:51	2024-04-02 17:59:51
5	58460869	Dr. Isabel Kub II	javon.adams@example.org	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	S4TQpScT8E	2024-04-02 17:59:51	2024-04-02 17:59:51
6	23080165	Miss Christy Jacobson Sr.	pstoltenberg@example.net	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	I1WxijFXrU	2024-04-02 17:59:51	2024-04-02 17:59:51
7	23077795	Prof. Tiara Zemlak III	jacobi.luella@example.net	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	DtKVmoWuHR	2024-04-02 17:59:51	2024-04-02 17:59:51
8	97631846	Morgan Vandervort	ekoelpin@example.com	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	GanHnd1cZy	2024-04-02 17:59:51	2024-04-02 17:59:51
9	77081002	Zula Schmidt IV	bwilderman@example.org	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	WNwnKdm7RU	2024-04-02 17:59:51	2024-04-02 17:59:51
10	19857710	Candace Hudson	ike22@example.net	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	45BvyuJzLW	2024-04-02 17:59:51	2024-04-02 17:59:51
11	31381710	Damion Pacocha	murphy.harley@example.org	2024-04-02 17:59:51	$2y$12$nl0J31lziabGJiMlJN/dOuxLxINQo1RlDQawSNbY9FNiVAsvp9pze	R0QJcTUJKj	2024-04-02 17:59:51	2024-04-02 17:59:51
\.


--
-- Name: cargos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cargos_id_seq', 220, true);


--
-- Name: ccp_locations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ccp_locations_id_seq', 15, true);


--
-- Name: ccps_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ccps_id_seq', 172, true);


--
-- Name: employee_ccp_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employee_ccp_id_seq', 1, false);


--
-- Name: employees_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employees_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 11, true);


--
-- Name: people_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.people_id_seq', 10, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 10, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: rangos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rangos_id_seq', 25, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 11, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 11, true);


--
-- Name: cargos cargos_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cargos
    ADD CONSTRAINT cargos_name_unique UNIQUE (name);


--
-- Name: cargos cargos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cargos
    ADD CONSTRAINT cargos_pkey PRIMARY KEY (id);


--
-- Name: ccp_locations ccp_locations_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccp_locations
    ADD CONSTRAINT ccp_locations_name_unique UNIQUE (name);


--
-- Name: ccp_locations ccp_locations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccp_locations
    ADD CONSTRAINT ccp_locations_pkey PRIMARY KEY (id);


--
-- Name: ccps ccps_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccps
    ADD CONSTRAINT ccps_code_unique UNIQUE (code);


--
-- Name: ccps ccps_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccps
    ADD CONSTRAINT ccps_pkey PRIMARY KEY (id);


--
-- Name: employee_ccp employee_ccp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_ccp
    ADD CONSTRAINT employee_ccp_pkey PRIMARY KEY (id);


--
-- Name: employees employees_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_code_unique UNIQUE (code);


--
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: people people_first_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_first_name_unique UNIQUE (first_name);


--
-- Name: people people_identification_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_identification_number_unique UNIQUE (identification_number);


--
-- Name: people people_last_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_last_name_unique UNIQUE (last_name);


--
-- Name: people people_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.people
    ADD CONSTRAINT people_pkey PRIMARY KEY (id);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: rangos rangos_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rangos
    ADD CONSTRAINT rangos_name_unique UNIQUE (name);


--
-- Name: rangos rangos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.rangos
    ADD CONSTRAINT rangos_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: users users_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_code_unique UNIQUE (code);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: ccps ccps_ccp_location_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ccps
    ADD CONSTRAINT ccps_ccp_location_id_foreign FOREIGN KEY (ccp_location_id) REFERENCES public.ccp_locations(id);


--
-- Name: employee_ccp employee_ccp_ccp_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_ccp
    ADD CONSTRAINT employee_ccp_ccp_id_foreign FOREIGN KEY (ccp_id) REFERENCES public.ccps(id);


--
-- Name: employee_ccp employee_ccp_employee_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_ccp
    ADD CONSTRAINT employee_ccp_employee_id_foreign FOREIGN KEY (employee_id) REFERENCES public.employees(id);


--
-- Name: employees employees_person_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_person_id_foreign FOREIGN KEY (person_id) REFERENCES public.people(id);


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

