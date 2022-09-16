# Tratamiento de datos
import pandas as pd
import numpy as np
# Gráficos
import seaborn as sns
import matplotlib.pyplot as plt
# Preprocesado y modelado
import scipy.stats as st
from sklearn import metrics
from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics import r2_score , accuracy_score, confusion_matrix, plot_confusion_matrix, classification_report
from sklearn.model_selection import train_test_split, KFold, cross_val_score
from sklearn.neighbors import KNeighborsClassifier


%matplotlib inline
plt.rcParams['figure.figsize'] = (7, 5)
urlDist = 'dfdistancia.csv'
dist = pd.read_csv(urlDist, sep=";")
dist = dist.dropna(how='any')
data_x=dist.iloc[:,0:dist.columns.size-1].values
data_y=dist.iloc[:,dist.columns.size-1].values
X_train,X_test,y_train,y_test = train_test_split(data_x, data_y,random_state=42)
k_range = range(2, 10)
scores = []
for k in k_range:
    knn = KNeighborsClassifier(n_neighbors = k)
    knn.fit(X_train, y_train)
    scores.append(knn.score(X_test, y_test))
plt.figure(figsize=(8,7))
plt.xlabel('k')
plt.ylabel('accuracy')
plt.scatter(k_range, scores)
plt.xticks([2,3,4,5,6,7,8,9,10])
plt.show()
knn=KNeighborsClassifier(n_neighbors=2, metric='euclidean')
knn.fit(X_train, y_train)
y_pred = knn.predict(X_test)
ue, ce = np.unique(y_test, return_counts=True)
print("Clasificacion \n",np.asarray((ue,ce)))
plot_confusion_matrix(knn, X_test, y_test)
plt.show()
print("Precision del modelo: "f'{knn.score(X_test, y_test):.2%}')

from matplotlib.colors import ListedColormap
x_set, y_set = X_train, y_train
x1, x2 = np.meshgrid(np.arange(start = x_set[:, 0].min() - 1, stop = x_set[:, 0].max() + 1, step  =0.01),
np.arange(start = x_set[:, 1].min() - 1, stop = x_set[:, 1].max() + 1, step = 0.01))
plt.contourf(x1, x2, knn.predict(np.array([x1.ravel(), x2.ravel()]).T).reshape(x1.shape),
alpha = 0.75, cmap = ListedColormap(('#FFAAAA', '#ffffb3')))
plt.xlim(x1.min(), x1.max())
plt.ylim(x2.min(), x2.max())
for i, j in enumerate(np.unique(y_set)):
    plt.scatter(x_set[y_set == j, 0], x_set[y_set == j, 1],
        c = ListedColormap(('#FFAAAA', '#ffffb3'))(i), label = j, edgecolor='k', s=20)
plt.title('K-NN Algorithm (Training set)')
plt.xlabel('Distancia')
plt.ylabel('Duración Estimada')
plt.legend()
plt.show()
