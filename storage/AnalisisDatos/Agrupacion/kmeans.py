# Tratamiento de datos
import pandas as pd
import numpy as np
# Gráficos
import seaborn as sns
import matplotlib.pyplot as plt
import matplotlib.cm as cm
# Preprocesado y modelado
import scipy.stats as st
from scipy.spatial.distance import cdist
from sklearn import linear_model, metrics, preprocessing
from sklearn.metrics import r2_score, confusion_matrix, pairwise_distances_argmin, silhouette_score, silhouette_samples
from sklearn.model_selection import train_test_split, KFold, cross_val_score
from sklearn.cluster import KMeans
from sklearn.preprocessing import MinMaxScaler
from yellowbrick.cluster import KElbowVisualizer, SilhouetteVisualizer


urlTemp = 'dftemperatura.csv'
df = pd.read_csv(urlTemp, sep=";")
dftemperatura = df[['temperatura','duracion']].copy()
min_max_scaler =MinMaxScaler()
df_escalado = min_max_scaler.fit_transform(dftemperatura)
df_escalado = pd.DataFrame(df_escalado)
df_escalado = df_escalado.rename(columns = {0: 'temperatura', 1: 'duracion'})
#--
x = df_escalado['temperatura'].values
y = df_escalado['duracion'].values
plt.xlabel('temperatura')
plt.ylabel('duracion')
plt.title('setTemperatura - Kmeans')
plt.plot(x,y,'o',markersize=5)
#--
inercia = []
for i in range(1, 10):
    algoritmo = KMeans(n_clusters = i, init = 'k-means++',
                       max_iter = 300, n_init = 10, random_state=42)
    algoritmo.fit(df_escalado)
    inercia.append(algoritmo.inertia_)
plt.figure(figsize=[10,6])
plt.title('Método del Codo para conocer valor óptimo de k clusters')
plt.xlabel('No. de clusters')
plt.ylabel('Inercia')
plt.plot(list(range(1, 10)), inercia, marker='o')
plt.show()
km = KMeans(n_clusters=2,init='k-means++',max_iter=300, random_state=42).fit(df_escalado)
centroides, etiquetas = km.cluster_centers_, km.labels_
print('Centroides:',centroides)
print('Centroides:\n',centroides,'\n','Etiquetas:\n',etiquetas)
score = silhouette_score(df_escalado, km.labels_, metric='euclidean')
print('Silhouetter Score: %.3f' % score)
y_km = km.fit_predict(df_escalado)
plt.figure(figsize=(8,8))
x = df_escalado['temperatura'].values
y = df_escalado['duracion'].values
plt.xlabel('temperatura')
plt.ylabel('duracion')
plt.title('setTemperatura - Kmeans')
plt.scatter(df_escalado[y_km == 0]['temperatura'], df_escalado[y_km == 0]['duracion'],
            s=50, c='green', marker='o',
            edgecolor='black', label='cluster 1')
plt.scatter(df_escalado[y_km == 1]['temperatura'], df_escalado[y_km == 1]['duracion'],
            s=50, c='orange', marker='s',
            edgecolor='black', label='cluster 2')
plt.scatter(km.cluster_centers_[:, 0],
            km.cluster_centers_[:, 1], s=200,
            marker='*', c='red',
            edgecolor='black', label='centroides')
plt.legend(loc="best")
plt.grid()
plt.show()
